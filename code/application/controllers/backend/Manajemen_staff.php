<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_staff extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_staff','m_staffgroup'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('manajemen_staff'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Manajemen Staff';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/manajemen_staff'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        $data['data_group'] = $this->m_staffgroup->get();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/manajemen_staff/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("stf_status != ".DELETED);

        $this->m_staff->get_datatable(implode(" AND ",$filter_cols),"stf_name desc");
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('stf_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_staff->set_select_mode('detail');
        $detail = $this->m_staff->get_by_multiple_column(array(
                                                                    'stf_id' => $pk_id,
                                                                    'stf_status !=' => DELETED
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
        $this->form_validation->set_rules('stf_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('stf_group'  , 'Group Staff'  , 'required|integer');
        $this->form_validation->set_rules('stf_name'  , 'Nama Staff'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('stf_username'  , 'Username Staff'  , 'trim|max_length[255]');
        $this->form_validation->set_rules('stf_email'  , 'Email Staff'         , 'trim|max_length[255]');
        $this->form_validation->set_rules('stf_password'  , 'Password Staff'  , 'trim|password|max_length[255]');
        $this->form_validation->set_rules('stf_status'  , 'Status Staff'  , 'integer');

        if($this->input->post('stf_id') == '')
			$this->form_validation->set_rules('stf_password' , 'Password Staff' , 'required|min_length[6]|max_length[30]');
		else
			$this->form_validation->set_rules('stf_password' , 'Password Staff' , 'min_length[6]|max_length[30]');
        
        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('stf_id') == ''){
                $stf_id = $this->m_staff->insert($this->input->post('stf_name'),
                                                $this->input->post('stf_username'),
                                                $this->input->post('stf_email'),
                                                password_hash($this->input->post('stf_password'),PASSWORD_DEFAULT),
                                                FALSE,
                                                $this->input->post('stf_status') == ACTIVE ? ACTIVE : SUSPEND,
                                                $current_time,
                                                $current_time
                                                );
                $this->db->insert('staffgroupaccess',array(
                                                            'sga_staff'      => $stf_id,
                                                            'sga_staffgroup' => $this->input->post('stf_group')
                                                        ));
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('stf_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_staff->get_by_multiple_column(array(
                                                'stf_id' => $pk_id,
                                                'stf_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_staff->update($pk_id,
                                                $this->input->post('stf_name'),
                                                $this->input->post('stf_username'),
                                                $this->input->post('stf_email'),
                                                ($this->input->post('stf_password') !== "") ?\
                                                password_hash($this->input->post('stf_password'),PASSWORD_DEFAULT) : FALSE,
                                                FALSE,
                                                $this->input->post('stf_status') == ACTIVE ? ACTIVE : SUSPEND,
                                                FALSE,
                                                $current_time
                                                );
                    $this->db->update('staffgroupaccess',array(
                        'sga_staffgroup' => $this->input->post('stf_group')
                        ),'sga_staff = '.$pk_id);
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
        if($this->input->post('stf_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('stf_id') as $row){
			$row = intval($row);
            $deleted = $this->m_staff->get_by_column($row);
			if($deleted !== NULL){
                $this->m_staff->update_single_column('stf_status', DELETED, $row);
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