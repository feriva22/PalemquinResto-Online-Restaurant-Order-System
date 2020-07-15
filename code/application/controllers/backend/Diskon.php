<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diskon extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_diskon'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('diskon'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Diskon';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/diskon'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/diskon/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("dsc_status != ".DELETED);

        $this->m_diskon->get_datatable(implode(" AND ",$filter_cols),"dsc_name desc");
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('dsc_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_diskon->set_select_mode('detail');
        $detail = $this->m_diskon->get_by_multiple_column(array(
                                                                    'dsc_id' => $pk_id,
                                                                    'dsc_status !=' => DELETED
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
		$this->form_validation->set_rules('dsc_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('dsc_name'  , 'Nama Diskon'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('dsc_value' , 'Nilai Diskon'  , 'required|integer');
        $this->form_validation->set_rules('dsc_unit' , 'Unit Diskon'  , 'integer'); 
        $this->form_validation->set_rules('dsc_expired'  , 'Masa Tenggang Diskon'  , 'trim|required|max_length[255]');       
        $this->form_validation->set_rules('dsc_status', 'Status', 'integer');
        
        if($this->form_validation->run()){
            //insert
            if($this->input->post('dsc_id') == ''){
                $dsc_id = $this->m_diskon->insert($this->input->post('dsc_name'),
                                                $this->input->post('dsc_value'),
                                                $this->input->post('dsc_unit') == CASH ? CASH : PERCENT,
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
                $edited = $this->m_diskon->get_by_multiple_column(array(
                                                'dsc_id' => $pk_id,
                                                'dsc_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_diskon->update($pk_id,
                                                $this->input->post('dsc_name'),
                                                $this->input->post('dsc_value'),
                                                $this->input->post('dsc_unit') == CASH ? CASH : PERCENT,
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
            $deleted = $this->m_diskon->get_by_column($row);
			if($deleted !== NULL){
                $this->m_diskon->update_single_column('dsc_status', DELETED, $row);
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