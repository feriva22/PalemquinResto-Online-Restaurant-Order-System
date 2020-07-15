<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_tambahan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_menutambahan'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('menu_tambahan'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Menu tambahan';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/menu_tambahan'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/menu_tambahan/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("mad_status != ".DELETED);

        $this->m_menutambahan->get_datatable(implode(" AND ",$filter_cols),"mad_name desc");
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('mad_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_menutambahan->set_select_mode('detail');
        $detail = $this->m_menutambahan->get_by_multiple_column(array(
                                                                    'mad_id' => $pk_id,
                                                                    'mad_status !=' => DELETED
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
		$this->form_validation->set_rules('mad_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('mad_name'  , 'Nama Menu'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('mad_price' , 'Harga Menu'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('mad_status', 'Status', 'integer');
        
        if($this->form_validation->run()){
            //insert
            if($this->input->post('mad_id') == ''){
                $mad_id = $this->m_menutambahan->insert($this->input->post('mad_name'),
                                                $this->input->post('mad_price'),
                                                $this->input->post('mad_status') == PUBLISH ? PUBLISH : DRAFT
                                                );
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('mad_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_menutambahan->get_by_multiple_column(array(
                                                'mad_id' => $pk_id,
                                                'mad_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_menutambahan->update($pk_id,
                                                $this->input->post('mad_name'),
                                                $this->input->post('mad_price'),
                                                $this->input->post('mad_status') == PUBLISH ? PUBLISH : DRAFT
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
        if($this->input->post('mad_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('mad_id') as $row){
			$row = intval($row);
            $deleted = $this->m_menutambahan->get_by_column($row);
			if($deleted !== NULL){
                $this->m_menutambahan->update_single_column('mad_status', DELETED, $row);
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