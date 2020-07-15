<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_pemesananinvoice','m_pelanggan',
                                'm_pemesanan','m_pemesananmenu',
                                'm_pemesanantambahan','m_pajak',
                                'm_pemesananreservasi'));
        
        

        $this->auth->set_module('invoice'); //check for current module
        

        require_once APPPATH."/third_party/invoicr/invoicr.php";  
	}
	
	public function index()
	{
        $this->auth->authenticate(); //authenticate logged in user
        $this->auth->authorize();    //authorize the user 


        $this->auth->set_access_read();


        $data = array();
        $data['inv_code'] = $this->input->get('inv_code');

        $data['page_title'] = 'Invoice';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/invoice'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        $data['type_payment'] = $this->config->item('type_payment');

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/invoice/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->authenticate(); //authenticate logged in user
        $this->auth->authorize();    //authorize the user 
        $this->auth->set_access_read();

        $filter_cols = array();

        $this->m_pemesananinvoice->get_datatable(implode(" AND ",$filter_cols),"inv_date desc");
    }

    public function get_invoiceajax(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->authenticate(); //authenticate logged in user
        $this->auth->authorize();    //authorize the user 
        $this->auth->set_access_read();

        $query = trim($this->input->post('q'));
        $per_page = 30;
        $page = intval($this->input->post('page'));
        $filter_cols = "";
        $param_query = "(inv_code LIKE '%".$query."%')";

        $result = $this->m_pemesananinvoice->search($param_query,
                                        $page !== NULL ? $page : 0,
                                        $per_page);
        json_response('success','',$result,array('total_count' => count($result))); 
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->authenticate(); //authenticate logged in user
        $this->auth->authorize();    //authorize the user 
        $this->auth->set_access_read();

        $pk_id = $this->input->post('inv_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_pemesananinvoice->set_select_mode('detail');
        $detail = $this->m_pemesananinvoice->get_by_multiple_column(array(
                                                                    'inv_id' => $pk_id,
                                                                    'inv_status !=' => DELETED
                                                                ));
                                                            
        //output
        if($detail !== NULl) json_response('success','',$detail);
        else json_response('error','Data tidak ada');
    }

    public function edit(){
        $this->auth->authenticate(); //authenticate logged in user
        $this->auth->authorize();    //authorize the user 
        $this->auth->set_access_update();

        $this->save();
    }

    private function save(){
        if(!$this->input->is_ajax_request()) show_404();

        //validation
		$this->load->library('form_validation');
        $this->form_validation->set_rules('inv_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('inv_status'  , 'Status Staff'  , 'integer');

    
        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('inv_id') == ''){
                $inv_id = $this->m_pemesananinvoice->insert($this->input->post('inv_name'),
                                                $this->input->post('inv_detail'),
                                                $this->input->post('inv_type'),
                                                $this->input->post('inv_status') == PUBLISH ? PUBLISH : DRAFT
                                                );
               
                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('inv_id');
                //make integer
                $pk_id = intval($pk_id);
                $this->m_pemesananinvoice->set_select_mode('detail');
                $edited = $this->m_pemesananinvoice->get_by_multiple_column(array(
                                                'inv_id' => $pk_id
                                                ));
                if($edited !== NULL){
                    $this->m_pemesananinvoice->update($pk_id,
                                                FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,
                                                $this->input->post('inv_status'),
                                                FALSE,FALSE
                                                );
                    //change status of order, if invoice unpaid set order unpaid
                    //if invoice all paid , set order paid
                    //if one of invoice paid , set order half paid
                    $tot_invoice = $this->m_pemesananinvoice->count_total('inv_order = '.$edited->inv_order);

                    $tot_paid = $this->m_pemesananinvoice->count_total('inv_order = '.$edited->inv_order.
                                                                        ' AND inv_status = '.PAID);
                    //check for tot invoice and tot paid
                    if($tot_invoice > 1){ //is DP
                        if($tot_paid == $tot_invoice) {$ord_status = PAID;}
                        else if($tot_paid > 0) {$ord_status = HALF_PAID;}
                        else {$ord_status = NOT_PAID;}
                    }else{
                        if($tot_paid == $tot_invoice) {$ord_status = PAID;}
                        else {$ord_status = NOT_PAID;}
                    }
                    //set order status
                    $this->m_pemesanan->update_single_column('ord_status',$ord_status,
                                                            $edited->inv_order,'ord_id');
                    
                    json_response('success','Sukses Edit');
                }else
                    json_response('error','Data tidak ditemukan');
            }
        }else
            json_response('error',validation_errors());
    }


    public function view_invoice(){
        $inv_code = $this->input->get('inv_code');
        $this->m_pemesananinvoice->set_select_mode('detail');
        $invoice_data = $this->m_pemesananinvoice->get("inv_code = '".$inv_code."'","",1);
        if($invoice_data == NULL){
            echo 'Invalid invoice code';
            exit;
        }
        $invoice = new Invoicr();

        // COMPANY INFO
        $invoice->set("company", [
            base_url().'assets/img/default/palemquinresto-logo.png',
            './assets/img/default/palemquinresto-logo.png', 
            "Palemquinresto", 
            "Jl. Raya Pacing Pacet Km. 20 Segunung",
            "Dlanggu,61371 Mojokerto",
            "Phone: (0321) 510866",
            "palemquinresto.com"
        ]);

        // INVOICE INFO
        
        $invoice->set("invoice", [
        	["Invoice #", $invoice_data->inv_code],
        	["Invoice Date", $invoice_data->inv_date],
        	["Due Date", $invoice_data->inv_duedate]
        ]);

        // BILL TO
        $cust_info = $this->m_pelanggan->get("cst_id = ".$invoice_data->inv_customer,"",1);

        $invoice->set("billto",[
            $cust_info->cst_name,
            $cust_info->cst_phone,
            $cust_info->cst_address
        ]);

        //SHIPPING , IF USE SHIPPING
        $this->m_pemesanan->set_select_mode('detail');
        $ord_info = $this->m_pemesanan->get("ord_id = ".$invoice_data->inv_order,"",1);
        $is_delivery = false;
        if($ord_info->ord_isdelivery == DELIVERY){
            $is_delivery = true;
            $invoice->set("shipto", [
                $ord_info->ord_delivaddress,
                $ord_info->ord_delivcity, 
                $ord_info->ord_delivprovince.','.$ord_info->ord_delivzip
            ]);
        }

        //ITEM
        //item menu and menu additional
        $item = [];
        //set if has reservasi
        if($ord_info->ord_type == RESERVASI){
            $this->m_pemesananreservasi->set_select_mode('detail');
            $reserv_info = $this->m_pemesananreservasi->get("odr_order = ".$ord_info->ord_id,"",1);
            $item[] = [
                "Reservasi meja ".$reserv_info->odr_table." (".$reserv_info->odr_people." orang)",
                "tanggal ".$reserv_info->odr_start,1,number_rp(0),number_rp(0)
            ];
        }
        $this->m_pemesananmenu->set_select_mode('detail');
        $this->m_pemesanantambahan->set_select_mode('detail');
        $ord_menu = $this->m_pemesananmenu->get("odm_order = ".$invoice_data->inv_order);

        foreach($ord_menu as $row){
            $item[] = array(
                $row->mnu_name,$row->odm_note,$row->odm_quantity,
                number_rp($row->odm_price),
                number_rp($row->odm_total)
            );
            $ord_tambahan = $this->m_pemesanantambahan->get("oma_ordermenu = ".$row->odm_id);
            foreach($ord_tambahan as $row_tambahan){
                $item[] = array(
                    $row_tambahan->mad_name,'tambahan',$row_tambahan->oma_quantity,
                    number_rp($row_tambahan->mad_price),
                    number_rp($row_tambahan->oma_total)
                );
            }
        }
        foreach ($item as $i) { $invoice->add("items", $i); }

        $payment_item = [
            ["SUB-TOTAL",number_rp($ord_info->ord_subtotal)]
        ];
        //calculate the discount
        if($ord_info->ord_discount !== NULL){
            $payment_item[] = [$ord_info->dsc_name, 
                                '-'.number_rp($this->calcDiscount(
                                                $ord_info->ord_subtotal,
                                                $ord_info->dsc_value,
                                                $ord_info->dsc_unit
                                            ))];
        }
        //calculate the tax
        $ord_tax = $this->db->get_where('order_tax',array( 'ort_order' => $ord_info->ord_id))->result();
        $use_tax = false;
        if(count($ord_tax) > 0){
            $use_tax = true;
            foreach($ord_tax as $tax){
                $res_tax = $this->calcTax($ord_info->ord_subtotal,$tax->ort_tax);
                $payment_item[] = [$res_tax[0],'+'.number_rp($res_tax[1])];
            }
        }
        

        $payment_item[] = [ "GRAND-TOTAL" , number_rp($ord_info->ord_total)];
        if($invoice_data->inv_isdp !== NULL){
            $payment_item[] = ["DP ".$invoice_data->inv_dpvalue."%",number_rp($invoice_data->inv_total)];
        }

        // 2F - TOTALS
        $invoice->set("totals", $payment_item);

        $invoice->set("notes", [
            $use_tax ? "" : "*Item diatas belum termasuk pajak",
            $is_delivery ? "*Biaya ongkir belum termasuk" : ""
        ]);
        

        $invoice->template("simple");

        $invoice->outputHTML();
    }


    private function calcDiscount($totalItem,$dsc_value,$dsc_unit){
        if($dsc_unit == "cash"){
            return intval($dsc_value);
        }else{// if tax is percent
            return $totalItem * (intval($dsc_value)/100);
        }
    }

    private function calcTax($totalItem, $tax_id){
        $tax_data = $this->m_pajak->get("tax_id = ".$tax_id,"",1);
        if($tax_data->tax_unit === "cash"){
            return array($tax_data->tax_name,intval($tax_data->tax_value));
        }else{// if tax is percent
            return array($tax_data->tax_name,$totalItem * (intval($tax_data->tax_value)/100));
        }
    }

    
}