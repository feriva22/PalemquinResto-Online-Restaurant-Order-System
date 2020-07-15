<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pajak extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_pajak'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('daftar_pajak'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Daftar Pajak';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/daftar_pajak'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/daftar_pajak/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("tax_status != ".DELETED);

        $this->m_pajak->get_datatable(implode(" AND ",$filter_cols),"tax_id desc");
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('tax_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_pajak->set_select_mode('detail');
        $detail = $this->m_pajak->get_by_multiple_column(array(
                                                                    'tax_id' => $pk_id,
                                                                    'tax_status !=' => DELETED
                                                                ));
                                                            
        //output
        if($detail !== NULl) json_response('success','',$detail);
        else json_response('error','Data tidak ada');
    }

    public function add(){

		$this->auth->set_access_create();

		$this->save();
    }
    
    public function edit(){
        $this->auth->set_access_update();

        $this->save();
    }

    private function save(){
        if(!$this->input->is_ajax_request()) show_404();

        //validation
		$this->load->library('form_validation');
		$this->form_validation->set_rules('tax_id'    , 'Id Pajak'            , 'integer');
        $this->form_validation->set_rules('tax_name'  , 'Nama Pajak'  , 'trim|required|max_length[45]');
        $this->form_validation->set_rules('tax_description' , 'Deskripsi Pajak'  , 'trim|required|max_length[45]');
        $this->form_validation->set_rules('tax_value' , 'Nilai Pajak'  , 'integer|required');
        $this->form_validation->set_rules('tax_unit' , 'Jenis Pajak'  , 'integer');
        $this->form_validation->set_rules('tax_status', 'Status', 'integer');
        
        if($this->form_validation->run()){

            $current_time = date('Y-m-d H:i:s');

            //insert
            if($this->input->post('tax_id') == ''){
                $tax_id = $this->m_pajak->insert(
                                                $this->input->post('tax_name'),
                                                $this->input->post('tax_description'),
                                                $this->input->post('tax_value'),
                                                $this->input->post('tax_unit')== CASH ? CASH : PERCENT,
                                                $this->input->post('tax_status') == PUBLISH ? PUBLISH : DRAFT,
                                                $current_time,
                                                $current_time
                                                );
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('tax_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_pajak->get_by_multiple_column(array(
                                                'tax_id' => $pk_id,
                                                'tax_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_pajak->update($pk_id,
                                               $this->input->post('tax_name'),
                                                $this->input->post('tax_description'),
                                                $this->input->post('tax_value'),
                                                $this->input->post('tax_unit')== CASH ? CASH : PERCENT,
                                                $this->input->post('tax_status') == PUBLISH ? PUBLISH : DRAFT,
                                                FALSE,
                                                $current_time
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
        if($this->input->post('tax_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('tax_id') as $row){
			$row = intval($row);
            $deleted = $this->m_pajak->get_by_column($row);
			if($deleted !== NULL){
                $this->m_pajak->update_single_column('tax_status', DELETED, $row);
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