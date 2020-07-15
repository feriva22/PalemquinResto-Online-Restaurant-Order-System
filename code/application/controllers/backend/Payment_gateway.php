<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_gateway extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_paygateway'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('payment_gateway'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Payment gateway';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/payment_gateway'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        $data['type_payment'] = $this->config->item('type_payment');

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/payment_gateway/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("pyg_status != ".DELETED);

        $this->m_paygateway->get_datatable(implode(" AND ",$filter_cols),"pyg_name desc");
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('pyg_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_paygateway->set_select_mode('detail');
        $detail = $this->m_paygateway->get_by_multiple_column(array(
                                                                    'pyg_id' => $pk_id,
                                                                    'pyg_status !=' => DELETED
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
        $this->form_validation->set_rules('pyg_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('pyg_name'  , 'Nama payment gateway'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('pyg_detail'  , 'Detail Payment gateway'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('pyg_type'  , 'Tipe'         , 'required|integer');
        $this->form_validation->set_rules('pyg_status'  , 'Status Staff'  , 'integer');

    
        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('pyg_id') == ''){
                $pyg_id = $this->m_paygateway->insert($this->input->post('pyg_name'),
                                                $this->input->post('pyg_detail'),
                                                $this->input->post('pyg_type'),
                                                $this->input->post('pyg_status') == PUBLISH ? PUBLISH : DRAFT
                                                );
               
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('pyg_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_paygateway->get_by_multiple_column(array(
                                                'pyg_id' => $pk_id,
                                                'pyg_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_paygateway->update($pk_id,
                                                $this->input->post('pyg_name'),
                                                $this->input->post('pyg_detail'),
                                                $this->input->post('pyg_type'),
                                                $this->input->post('pyg_status') == PUBLISH ? PUBLISH : DRAFT
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
        if($this->input->post('pyg_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('pyg_id') as $row){
			$row = intval($row);
            $deleted = $this->m_paygateway->get_by_column($row);
			if($deleted !== NULL){
                $this->m_paygateway->update_single_column('pyg_status', DELETED, $row);
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