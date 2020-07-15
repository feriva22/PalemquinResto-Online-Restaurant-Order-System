<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_pemesanan','m_pemesananinvoice','m_transaksi'));
        
        $this->auth->authenticate();
	}
	
	public function index()
	{
		$data = array();

        $data['page_title'] = 'Dashboard';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/dashboard'
        );
        $data['assets_js'] = array();
        $data['tot_catering'] = count($this->m_pemesanan->get("ord_type = ".KATERING));
        $data['tot_reservasi'] = count($this->m_pemesanan->get("ord_type = ".RESERVASI));
        $data['inv_paid'] = count($this->m_pemesananinvoice->get("inv_status = ".PAID));
        $data['trs_wait'] = count($this->m_transaksi->get("trs_status = ".WAITING));

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/dashboard/index');
        $this->load->view('backend/__base/footer_dashboard',$data);
    }
    
}
