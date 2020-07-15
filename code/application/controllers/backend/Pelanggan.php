<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_pelanggan'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('pelanggan'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Pelanggan';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/pelanggan'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/pelanggan/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("cst_status != ".DELETED,"cst_status != ".NO_CREDENTIAL);

        $this->m_pelanggan->get_datatable(implode(" AND ",$filter_cols),"cst_name asc");
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('cst_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_pelanggan->set_select_mode('detail');
        $detail = $this->m_pelanggan->get_by_multiple_column(array(
                                                                    'cst_id' => $pk_id,
                                                                    'cst_status !=' => DELETED
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
		$this->form_validation->set_rules('cst_id'    , 'Id Pelanggan'            , 'integer');
        $this->form_validation->set_rules('cst_name'  , 'Nama Pelanggan'  , 'trim|required|max_length[45]');
        $this->form_validation->set_rules('cst_phone' , 'Nomor HP'  , 'trim|required|max_length[45]');
        $this->form_validation->set_rules('cst_email' , 'Email Pelanggan'  , 'trim|required|max_length[45]');
        $this->form_validation->set_rules('cst_birthday' , 'Tanggal Lahir'  , 'trim|max_length[45]');
        $this->form_validation->set_rules('cst_gender' , 'Jenis Kelamin'  , 'integer');
        $this->form_validation->set_rules('cst_address' , 'Alamat Pelanggan'  , 'trim|max_length[50]');
        $this->form_validation->set_rules('cst_username' , 'Username'  , 'trim|max_length[45]');
        $this->form_validation->set_rules('cst_password'  , 'Password'  , 'trim|required|max_length[45]');
        $this->form_validation->set_rules('cst_status', 'Status', 'integer');
        
        if($this->form_validation->run()){

            $current_time = date('Y-m-d H:i:s');

            //insert
            if($this->input->post('cst_id') == ''){
                $cst_id = $this->m_pelanggan->insert(
                                                $this->input->post('cst_name'),
                                                $this->input->post('cst_phone'),
                                                $this->input->post('cst_email'),
                                                $this->input->post('cst_birthday'),
                                                $this->input->post('cst_gender'),
                                                $this->input->post('cst_address'),
                                                $this->input->post('cst_username'),
                                                password_hash($this->input->post('stf_password'),PASSWORD_DEFAULT),
                                                $this->input->post('cst_status') == ACTIVE ? ACTIVE : SUSPEND,
                                                $current_time,
                                                $current_time
                                                );
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('cst_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_pelanggan->get_by_multiple_column(array(
                                                'cst_id' => $pk_id,
                                                'cst_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_pelanggan->update($pk_id,
                                                $this->input->post('cst_name'),
                                                $this->input->post('cst_phone'),
                                                $this->input->post('cst_email'),
                                                $this->input->post('cst_birthday'),
                                                $this->input->post('cst_gender'),
                                                $this->input->post('cst_address'),
                                                $this->input->post('cst_username'),
                                                ($this->input->post('cst_password') !== "") ?\
                                                password_hash($this->input->post('cst_password'),PASSWORD_DEFAULT) : FALSE,
                                                $this->input->post('cst_status') == ACTIVE ? ACTIVE : SUSPEND,
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
        if($this->input->post('cst_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('cst_id') as $row){
			$row = intval($row);
            $deleted = $this->m_pelanggan->get_by_column($row);
			if($deleted !== NULL){
                $this->m_pelanggan->update_single_column('cst_status', DELETED, $row);
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