<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class meja_reservasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_tablemap','m_setting','m_pemesananreservasi'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('meja_reservasi'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Meja Reservasi';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/meja_reservasi'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/meja_reservasi/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function upload_map(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_update();

        $res = $this->m_setting->get("stg_name = 'tablemap_img'","",1);
        if($res->stg_value !== ""){
            delete_media_photo($res->stg_value);
        }
        $upload_status = upload_media_photo('image','./assets/img/default');
        if(!$upload_status->success){
            json_response('error',$upload_status->data);
        }

        $this->m_setting->update('tablemap_img',
                                'assets/img/default/'.$upload_status->data['file_name'],
                                FALSE);
        
        json_response('success','success upload new map');
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();
        //get the image of map
        $map_url = $this->m_setting->get("stg_name = 'tablemap_img'","",1);
        $map_data = $this->m_tablemap->get();
        if($map_url->stg_value == ""){
            //if kosong nilai stg value
            json_response('error','Upload terlebih dahulu map meja');
        }
        list($width, $height, $type, $attr) = getimagesize('./'.$map_url->stg_value);

        $response = new stdClass();
        $response->imageData    = array(
                                        'url' => $map_url->stg_value,
                                        'width' => $width,
                                        'height' => $height
                                );
        $response->map_data     = NULL;

        foreach($map_data as $row){
            $response->map_data[] = (object) array(
                'tbm_id'    => $row->tbm_id,
                'tbm_name'  => $row->tbm_name,
                'tbm_max'   => $row->tbm_max,
                'tbm_min'   => $row->tbm_min,
                'tbm_attr'  => $row->tbm_attr
            );
        }

        json_response('success','',$response);
    }   

    public function detail_order(){
        if(!$this->input->is_ajax_request()) show_404();
        $this->load->library('form_validation');

        $this->auth->set_access_read();
        $this->form_validation->set_rules('odr_fordate', 'Tanggal reservasi', 'trim|required');   
        $this->form_validation->set_rules('odr_people','Banyak orang','required|integer');
        if($this->form_validation->run()){

            $startDate       = date("Y-m-d H:i:s",strtotime($this->input->post('odr_fordate')));
            $optEndDefault   = $this->m_setting->get("stg_name = 'reservationend_default'","",1);
            $endDate         = date("Y-m-d H:i:s",strtotime('+'.intval($optEndDefault->stg_value).' minutes',
                                    strtotime($this->input->post('odr_fordate'))));
            $peopleCount     = $this->input->post('odr_people');
      
            //get the image of map
            $map_url = $this->m_setting->get("stg_name = 'tablemap_img'","",1);
            $map_data = $this->m_tablemap->get();
            if($map_url->stg_value == ""){
                //if kosong nilai stg value
                json_response('error','Upload terlebih dahulu map meja');
            }
            list($width, $height, $type, $attr) = getimagesize('./'.$map_url->stg_value);

            $response = new stdClass();
            $response->imageData    = array(
                                            'url' => $map_url->stg_value,
                                            'width' => $width,
                                            'height' => $height
                                    );

            $response->map_data     = NULL;
                                
            foreach($map_data as $row){
                $response->map_data[] = (object) array(
                    'tbm_id'        => $row->tbm_id,
                    'tbm_name'      => $row->tbm_name,
                    'tbm_max'       => $row->tbm_max,
                    'tbm_min'       => $row->tbm_min,
                    'tbm_attr'      => $row->tbm_attr,
                    'tbm_color'     => ($this->order_check($row->tbm_max,
                                                        $row->tbm_min,
                                                        $startDate,
                                                        $endDate,
                                                        $peopleCount,
                                                        $row->tbm_id) ? "#d82020" : "#c0d6e4"),
                    'tbm_selected'  => $this->order_check($row->tbm_max,
                                                        $row->tbm_min,
                                                        $startDate,
                                                        $endDate,
                                                        $peopleCount,
                                                        $row->tbm_id)
                    );
            }

            json_response('success','',$response);
        }else{
            json_response('error',validation_errors());
        }
    }

    private function order_check($max,$min,$startDate,$endDate,$peopleCount,$id_table){
        $result = $this->m_pemesananreservasi->get_by_multiple_column(array(
                                                'odr_table' => $id_table,
                                                'odr_start <=' => $startDate,
                                                'odr_end >'   => $startDate,
                                                'odr_status' => PROCESS
                                                ),200);
        $check_people = ((int) $peopleCount <= (int) $max && (int) $peopleCount >= (int) $min ? true : false);

        if(count($result) == 0 && $check_people)
            return true; //NO ORDER WITH THIS PARAMETER
        else
            return false; //HAVE ORDER WITH THIS PARAMETER
    }



    public function edit(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_update();

        $this->m_tablemap->erase();

        $table_map = $this->input->post('table_map');
        $iter = 0;
        foreach($table_map as $item){
            $this->m_tablemap->insert(
                                        $item['tbm_id'],
                                        $item['tbm_name'],
                                        $item['tbm_max'],
                                        $item['tbm_min'],
                                        json_encode($item['tbm_attr'])
                                    );
            $iter++;
        }
        if($iter === sizeof($table_map)){
            json_response('success','Sukses menyimpan data');
        }else{
            json_response('error','Gagal menyimpan data');
        }
    }







    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("dsc_status != ".DELETED);

        $this->m_tablemap->get_datatable(implode(" AND ",$filter_cols),"dsc_name desc");
    }


    public function add(){

		$this->auth->set_access_create();

		$this->save();
    }
    
    private function save(){
        if(!$this->input->is_ajax_request()) show_404();

        //validation
		$this->load->library('form_validation');
		$this->form_validation->set_rules('dsc_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('dsc_name'  , 'Nama meja_reservasi'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('dsc_value' , 'Nilai meja_reservasi'  , 'required|integer');
        $this->form_validation->set_rules('dsc_unit' , 'Unit meja_reservasi'  , 'integer'); 
        $this->form_validation->set_rules('dsc_expired'  , 'Masa Tenggang meja_reservasi'  , 'trim|required|max_length[255]');       
        $this->form_validation->set_rules('dsc_status', 'Status', 'integer');
        
        if($this->form_validation->run()){
            //insert
            if($this->input->post('dsc_id') == ''){
                $dsc_id = $this->m_tablemap->insert($this->input->post('dsc_name'),
                                                $this->input->post('dsc_value'),
                                                $this->input->post('dsc_unit'),
                                                $this->input->post('dsc_expired'),
                                                $this->input->post('dsc_status') == PUBLISH ? PUBLISH : DRAFT
                                                );
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('dsc_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_tablemap->get_by_multiple_column(array(
                                                'dsc_id' => $pk_id,
                                                'dsc_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_tablemap->update($pk_id,
                                                $this->input->post('dsc_name'),
                                                $this->input->post('dsc_value'),
                                                $this->input->post('dsc_unit'),
                                                $this->input->post('dsc_expired'),
                                                $this->input->post('dsc_status') == PUBLISH ? PUBLISH : DRAFT
                                                );
                    json_response('success','Sukses Edit');
                }else
                    json_response('error','Data tidak ditemukan');
            }
        }else
            json_response('error',validation_errors());
    }

    public function delete(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_delete();
        if($this->input->post('dsc_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('dsc_id') as $row){
			$row = intval($row);
            $deleted = $this->m_tablemap->get_by_column($row);
			if($deleted !== NULL){
                $this->m_tablemap->update_single_column('dsc_status', DELETED, $row);
                $all_deleted[] = array("id" => $row, "status" => "success");
			}
        }
        if(count($all_deleted) > 0){
            json_response('success','sukses hapus');
        }else{
            json_response('error','gagal hapus');
        }

    }


    
}