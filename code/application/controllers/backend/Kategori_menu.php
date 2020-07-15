<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_kategorimenu'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('kategori_menu'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Kategori menu';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/kategori_menu'
        );
        $data['assets_js'] = array();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/kategori_menu/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("mnc_status != ".DELETED);

        $this->m_kategorimenu->get_datatable(implode(" AND ",$filter_cols),"mnc_name desc");
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('mnc_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_kategorimenu->set_select_mode('detail');
        $detail = $this->m_kategorimenu->get_by_multiple_column(array(
                                                                    'mnc_id' => $pk_id,
                                                                    'mnc_status !=' => DELETED
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
		$this->form_validation->set_rules('mnc_id'    , 'Id'            , 'integer');
		$this->form_validation->set_rules('mnc_name'  , 'Nama Kategori'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('mnc_status', 'Status', 'integer');
        
        if($this->form_validation->run()){
            //insert
            if($this->input->post('mnc_id') == ''){
                $mnc_id = $this->m_kategorimenu->insert($this->input->post('mnc_name'),
                                                $this->input->post('mnc_status') == PUBLISH ? PUBLISH : DRAFT
                                                );
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('mnc_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_kategorimenu->get_by_multiple_column(array(
                                                'mnc_id' => $pk_id,
                                                'mnc_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_kategorimenu->update($pk_id,
                                                $this->input->post('mnc_name'),
                                                $this->input->post('mnc_status') == PUBLISH ? PUBLISH : DRAFT
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
        if($this->input->post('mnc_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('mnc_id') as $row){
			$row = intval($row);
            $deleted = $this->m_kategorimenu->get_by_column($row);
			if($deleted !== NULL){
                $this->m_kategorimenu->update_single_column('mnc_status', DELETED, $row);
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