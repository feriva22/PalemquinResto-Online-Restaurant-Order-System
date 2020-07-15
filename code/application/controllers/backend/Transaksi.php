<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_transaksi','m_paygateway'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('transaksi'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();
        $data['inv_code'] = $this->input->get('inv_code');

        $data['page_title'] = 'Transaksi';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/transaksi'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();
        $data['data_paygateway'] = $this->m_paygateway->get();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/transaksi/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array();

        $this->m_transaksi->get_datatable(implode(" AND ",$filter_cols),"trs_name desc");
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('trs_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_transaksi->set_select_mode('detail');
        $detail = $this->m_transaksi->get_by_multiple_column(array(
                                                                    'trs_id' => $pk_id
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
		$this->form_validation->set_rules('trs_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('trs_invoicecode'  , 'Kode invoice'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('trs_paygateway' , 'Metode pembayaran'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('trs_total', 'Total', 'integer');
        $this->form_validation->set_rules('trs_name', 'Nama', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('trs_email', 'Email', 'trim|max_length[255]');
        $this->form_validation->set_rules('trs_note','Catatan','trim|max_length[255]');
        $this->form_validation->set_rules('trs_status', 'Status', 'integer');
        
        if($this->input->post('trs_id') !== ''){
            $this->form_validation->set_rules('trs_invoicecode'  , 'Kode invoice'  , 'trim|max_length[255]');
            $this->form_validation->set_rules('trs_paygateway' , 'Metode pembayaran'  , 'trim|max_length[255]');
            $this->form_validation->set_rules('trs_name', 'Nama', 'trim|max_length[255]');
        }

        if($this->form_validation->run()){

            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('trs_id') == ''){

                if($_FILES['trs_photo']['name'] !== ""){
                    $upload_status = upload_media_photo('trs_photo','./assets/img/upload/transaksi');
                    
                    if(!$upload_status->success){
                        json_response('error',$upload_status->data);
                    }
                }

                $trs_id = $this->m_transaksi->insert(generate_code($this->m_transaksi->get_last_id(),7,'TRS-'),
                                                $current_time,
                                                $this->input->post('trs_invoicecode'),
                                                $this->input->post('trs_paygateway'),
                                                $this->input->post('trs_total'),
                                                $this->input->post('trs_name'),
                                                $this->input->post('trs_email'),
                                                $this->input->post('trs_note'),
                                                $_FILES['trs_photo']['name'] !== "" ? 
                                                'assets/img/upload/transaksi/'.$upload_status->data['file_name'] :
                                                FALSE,
                                                NOT_PAID
                                                );
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('trs_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_transaksi->get_by_multiple_column(array(
                                                'trs_id' => $pk_id
                ));
                if($edited !== NULL){
                    $current_photo = $edited->trs_photo !== NULL ? $edited->trs_photo : NULL;
                    if($_FILES['trs_photo']['name'] !== ""){
                        delete_media_photo($current_photo);
                        $upload_status = upload_media_photo('trs_photo','./assets/img/upload/transaksi');
                        if(!$upload_status->success){
                            json_response('error',$upload_status->data);
                        }
                        
                    }

                    $this->m_transaksi->update($pk_id,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                $_FILES['trs_photo']['name'] !== "" ? 
                                                'assets/img/upload/transaksi/'.$upload_status->data['file_name'] :
                                                FALSE,
                                                $this->input->post('trs_status')
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
        if($this->input->post('trs_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('trs_id') as $row){
			$row = intval($row);
            $deleted = $this->m_transaksi->get_by_column($row);
			if($deleted !== NULL){
                $this->m_transaksi->update_single_column('trs_status', DELETED, $row);
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