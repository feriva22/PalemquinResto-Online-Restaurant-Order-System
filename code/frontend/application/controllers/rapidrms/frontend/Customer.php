<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/rapidrms/frontend/TemplateRms.php");

class Customer extends TemplateRms {

    public function __construct(){
        parent::__construct();
		$this->load->model(array('menu/MenuModel','customer/MCustomer'));
		$this->load->library('cart');
        $this->load->library('email');

        if($this->session->userdata('logged_in') !== TRUE){
            $this->session->set_flashdata('alert', ['msg' => 'Silahkan login terlebih dahulu','status' => 'error']);
            redirect('auth');
        }

        if($this->session->userdata('last_page') !== null){
            redirect($this->session->userdata('last_page'));
        }
    }

    public function index(){

        $data['customer'] = $this->MCustomer->getCustomer(array(
                                        'cst_id' => $this->session->userdata('id'),
                                        'cst_status' => ACTIVE
                                    ));
        $data['customer'] = $data['customer']->row();

        $trs_accepted = $this->db->get_where('transaction',array(
                                                    'trs_email' => $this->session->userdata('email'),
                                                    'trs_status' => ACCEPTED));
        $data['trs_accepted'] = count($trs_accepted->result());

        $inv_unpaid = $this->db->get_where('invoice',array(
                                                    'inv_customer' => $this->session->userdata('id'),
                                                    'inv_status' => NOT_PAID));
        $data['inv_unpaid'] = count($inv_unpaid->result());

        $trs_rejected = $this->db->get_where('transaction',array(
                                                    'trs_email' => $this->session->userdata('email'),
                                                    'trs_status' => REJECTED));
        $data['trs_rejected'] = count($trs_rejected->result());
        
        

        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Profile Customer";
        $this->data["css"] = NULL;
		$this->data["js"] = NULL;
        $this->data["content"] = "profile.php";
        $this->data["records"] = array(
            "data" => $data
        );   
        $this->data["with_footer"] = false;
        $this->loadView();
    }

    public function invoice(){
        $data['customer'] = $this->MCustomer->getCustomer(array(
            'cst_id' => $this->session->userdata('id'),
            'cst_status' => ACTIVE
        ));
        $data['customer'] = $data['customer']->row();

        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Invoice Customer";
        $this->data["css"] = NULL;
        $this->data["js"] = array('cust_invoice.js');
        $this->data["content"] = "cust_invoice.php";
        $this->data["records"] = array(
        "data" => $data
        );   
        $this->data["with_footer"] = false;
        $this->loadView();
    }

    public function transaksi(){
        $data['customer'] = $this->MCustomer->getCustomer(array(
            'cst_id' => $this->session->userdata('id'),
            'cst_status' => ACTIVE
        ));
        $data['customer'] = $data['customer']->row();

        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Transaksi Customer";
        $this->data["css"] = NULL;
        $this->data["js"] = array('cust_transaction.js');
        $this->data["content"] = "cust_transaction.php";
        $this->data["records"] = array(
        "data" => $data
        );   
        $this->data["with_footer"] = false;
        $this->loadView();
    }

    public function get_invoice(){
        if(!$this->input->is_ajax_request()) show_404();

        $filter_cols = array();
        $this->MCustomer->listInvoice(array(
                                    'inv_customer' => $this->session->userdata('id')
        ));
    }

    public function get_transaction(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->MCustomer->listTransaction(array(
                                    'trs_email' => $this->session->userdata('email')
        ));
    }

    public function add_transaction(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('trs_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('trs_invoicecode'  , 'Invoice Code'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('trs_paygateway' , 'Payment gateway'  , 'required|trim|max_length[255]');
        $this->form_validation->set_rules('trs_total' , 'Total'  , 'integer|required'); 
        $this->form_validation->set_rules('trs_note', 'Catatan', 'trim|max_length[255]');

        if($this->form_validation->run()){
            
            $current_time = date('Y-m-d H:i:s');

            //insert
            if($this->input->post('trs_id') == ''){
                if($_FILES['trs_photo']['name'] !== ""){
                    $upload_status = upload_media_photo('trs_photo',$this->config->item('upload_backend_path').'assets/img/upload/transaksi');
                    if(!$upload_status->success){
                        json_response('error',$upload_status->data);
                    }
                }

                $trs_id = $this->MCustomer->addTransaction(array(
                                                'trs_code' => generate_code($this->MCustomer->get_lasttransaction_id(),7,'TRS-'),
                                                'trs_date' => date('Y-m-d H:i:s'),
                                                'trs_invoicecode' => $this->input->post('trs_invoicecode'),
                                                'trs_paygateway' => $this->input->post('trs_paygateway'),
                                                'trs_total' => $this->input->post('trs_total'),
                                                'trs_name' => $this->session->userdata('name'),
                                                'trs_email' => $this->session->userdata('email'),
                                                'trs_note' => $this->input->post('trs_note'),
                                                'trs_photo' => $_FILES['trs_photo']['name'] !== "" ? 
                                                'assets/img/upload/transaksi/'.$upload_status->data['file_name'] :NULL,
                                                'trs_status' => WAITING));
                redirect('customer/transaksi');
            }
            redirect('customer/transaksi');

        }
    }

    public function konfigurasi(){
        $data['customer'] = $this->MCustomer->getCustomer(array(
            'cst_id' => $this->session->userdata('id'),
            'cst_status' => ACTIVE
        ));
        $data['customer'] = $data['customer']->row();

        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Konfigurasi akun Customer";
        $this->data["css"] = NULL;
        $this->data["js"] = array();
        $this->data["content"] = "cust_info.php";
        $this->data["records"] = array(
        "data" => $data
        );   
        $this->data["with_footer"] = false;
        $this->loadView();
    }

    public function simpan_konfigurasi(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('cst_name','Nama Customer','required|trim|max_length[255]');
        $this->form_validation->set_rules('cst_phone','Nomor Telephon Customer','required|trim|max_length[15]');
        $this->form_validation->set_rules('cst_address','Nama Customer','required|trim|max_length[255]');

        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');

            $cst_id = intval($this->session->userdata('id'));

            $this->MCustomer->updateCustomer($cst_id,
                                            array(
                                                'cst_name' => $this->input->post('cst_name'),
                                                'cst_phone' => $this->input->post('cst_phone'),
                                                'cst_address' => $this->input->post('cst_address')
                                            )       
                                            );
            $this->session->set_flashdata('alert', ['msg' => 'Sukses update akun','status' => 'success']);
            redirect('customer/konfigurasi');
        }
        else{
            $this->session->set_flashdata('alert', ['msg' => 'Cek form anda','status' => 'error']);
            redirect('customer/konfigurasi');
        }
    }
}