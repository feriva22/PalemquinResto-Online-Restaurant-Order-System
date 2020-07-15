<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_pemesanan'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('laporan'); //check for current module
        
        $this->auth->authorize();    //authorize the user        

        $this->load->library('Pdf');
    }

    public function penjualan(){
        $this->auth->set_access_read();
    
		$data = array();

        $data['page_title'] = 'Laporan Penjualan';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/laporan_penjualan'
        );
        $data['assets_js'] = array();

        $type_report = $this->input->get('type_report');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $data['report'] = array();
        if($type_report == 'daily'){
            $sql_query = "SELECT DATE(ord_date) AS 'waktu',sum(inv_total) as 'tot_penjualan',sum( distinct get_total_tax(inv_order)) as 'tot_tax',
            sum(distinct get_total_discount(inv_order)) as 'tot_discount', 
            (sum(inv_total) - sum( distinct get_total_tax(inv_order)) - sum(distinct get_total_discount(inv_order))) as 'tot_net'
             FROM resto_db.order inner join invoice on ord_id = inv_order where 
            (ord_status = 2 OR ord_status = 1) AND DATE(ord_date) >= '".$start_date."' AND DATE(ord_date) <= '".$end_date."'
            GROUP BY DATE(ord_date)";

            $query = $this->db->query($sql_query);
            $data['report'] = $query->result();
        }
        else if($type_report == 'monthly'){
            $sql_query = "SELECT DATE_FORMAT(ord_date,'%Y-%m') AS 'waktu',sum(inv_total) as 'tot_penjualan',sum( distinct get_total_tax(inv_order)) as 'tot_tax',
            sum(distinct get_total_discount(inv_order)) as 'tot_discount', 
            (sum(inv_total) - sum( distinct get_total_tax(inv_order)) - sum(distinct get_total_discount(inv_order))) as 'tot_net'
             FROM resto_db.order inner join invoice on ord_id = inv_order where 
            (ord_status = 2 OR ord_status = 1) AND DATE_FORMAT(ord_date,'%Y-%m') >= '".$start_date."' AND DATE_FORMAT(ord_date,'%Y-%m') <= '".$end_date."'
            GROUP BY DATE_FORMAT(ord_date,'%Y-%m')";

            $query = $this->db->query($sql_query);
            $data['report'] = $query->result();
        }
        else{
            $sql_query = "SELECT DATE_FORMAT(ord_date,'%Y') AS 'waktu',sum(inv_total) as 'tot_penjualan',sum( distinct get_total_tax(inv_order)) as 'tot_tax',
            sum(distinct get_total_discount(inv_order)) as 'tot_discount', 
            (sum(inv_total) - sum( distinct get_total_tax(inv_order)) - sum(distinct get_total_discount(inv_order))) as 'tot_net'
             FROM resto_db.order inner join invoice on ord_id = inv_order where 
            (ord_status = 2 OR ord_status = 1) AND DATE_FORMAT(ord_date,'%Y') >= '".$start_date."' AND DATE_FORMAT(ord_date,'%Y') <= '".$end_date."'
            GROUP BY DATE_FORMAT(ord_date,'%Y')";

            $query = $this->db->query($sql_query);
            $data['report'] = $query->result();
        }
        
        $data['type_report'] = $type_report;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        if($this->input->get('act') == "download"){
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Laporan Penjualan Palemquinresto');
            $pdf->SetTopMargin(20);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->AddPage();
            $html = $this->load->view('backend/laporan/penjualan_pdf',$data,TRUE);
            $pdf->WriteHTML($html, true, false, true, false, '');
            $pdf->Output('penjualan_'.$type_report.'_'.$start_date.'-'.$end_date.'.pdf', 'D');
            exit;
        }

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/laporan/penjualan',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }


    


    

}