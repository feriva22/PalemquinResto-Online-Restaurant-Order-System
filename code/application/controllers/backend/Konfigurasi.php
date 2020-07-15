<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfigurasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_setting'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('konfigurasi'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Konfigurasi';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/konfigurasi'
        );
        $data['assets_js'] = array();
        $data['config'] = $this->m_setting->get();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/konfigurasi/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function save(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_update();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('invoiceend_default' , 'masa berlaku invoice pertama'  , 'required|integer');
        $this->form_validation->set_rules('invoiceend_finaldp' , 'masa berlaku invoice akhir'  , 'integer|required'); 
        $this->form_validation->set_rules('reservationend_default'  , 'masa reservasi tempat'  , 'required|integer');       
        $this->form_validation->set_rules('default_mindp', 'minim DP', 'integer|required');
        $this->form_validation->set_rules('allowed_deliveryaddr','Daerah Pengiriman', 'trim');

        if($this->form_validation->run()){
            $this->m_setting->update_single_column('stg_value',$this->input->post('invoiceend_default').' days',
                                                    'invoiceend_default','stg_name');

            $this->m_setting->update_single_column('stg_value',$this->input->post('invoiceend_finaldp').' days',
                                                    'invoiceend_finaldp','stg_name');

            $this->m_setting->update_single_column('stg_value',$this->input->post('reservationend_default'),
                                                    'reservationend_default','stg_name');

            $this->m_setting->update_single_column('stg_value',$this->input->post('default_mindp'),
                                                    'default_mindp','stg_name'); 

            $this->m_setting->update_single_column('stg_value',$this->input->post('allowed_deliveryaddr'),
                                                    'allowed_deliveryaddr','stg_name'); 
            
            json_response('success','Sukses ubah');
        }
        else{
            json_response('error',validation_errors());
        }
    }

}