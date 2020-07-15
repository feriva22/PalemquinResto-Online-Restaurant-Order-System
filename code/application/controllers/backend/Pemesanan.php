<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_pemesanan','m_pemesananmenu','m_pemesanantambahan',
                                'm_pemesananinvoice','m_pemesananreservasi','m_menu','m_menutambahan',
                                'm_diskon','m_pelanggan','m_pajak','m_paygateway',
                                'm_setting'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('pemesanan'); //check for current module
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Pemesanan';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/pemesanan'
        );
        $data['assets_js'] = array();

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/pemesanan/index',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function tambah_pemesanan(){
        $this->auth->set_access_read();

        $data['page_title'] = 'Tambah Pemesanan';
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/pemesanan_add'
        );
        $data['plugin'] = array('assets/dist/js/cartBackend.js');
        $data['data_diskon'] = $this->m_diskon->get('dsc_status != '.DELETED);
        $data['data_customer'] = $this->m_pelanggan->get('cst_status = '.ACTIVE);
        $data['data_pajak'] = $this->m_pajak->get('tax_status !='.DELETED);
        $data['data_paygateway'] = $this->m_paygateway->get('pyg_status !='.DELETED);

        $this->load->view('backend/__base/header_dashboard',$data);
        $this->load->view('backend/__base/sidebar',$data);
        $this->load->view('backend/pemesanan/detail',$data);
        $this->load->view('backend/__base/footer_dashboard',$data);
    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array();

        $this->m_pemesanan->get_datatable(implode(" AND ",$filter_cols),"ord_date desc");
    }

    public function cancel_order(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();
        $current_time = date('Y-m-d H:i:s');

        if($this->input->post('ord_id') !== NULL){
            $pk_id = intval($this->input->post('ord_id'));

            //change to order
            $this->m_pemesanan->update($pk_id,
                                        FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,
                                        FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,
                                        CANCELED,
                                        FALSE,$current_time                            
                                        );
            //change to invoice, don't update to status with PAID
            $this->m_pemesananinvoice->update_single_column('inv_status',CANCELED,
                                                            array(
                                                                'inv_order' => $pk_id,
                                                                'inv_status !=' => PAID
                                                            ),'inv_order',TRUE);
            json_response('success','Sukses mengubah status');
        }else{
            json_response('error','Pilih pemesanan!');
        }
    }


    public function checkout(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_create();

        $current_time = date('Y-m-d H:i:s');

        if($this->input->post("ord_id") == NULL){ //get data for new order
            //calculate all item
            $subtotalItem = $this->calculateAllItem($this->input->post('order_item'));
            
            //calculate all discount
            $grandTotal = $this->calcuateAfterDiscount($subtotalItem,$this->input->post('ord_discount'));

            //calculate all tax
            $grandTotal = $this->calculateAfterTax($grandTotal, $subtotalItem,$this->input->post('tax'));

            $deliv_data = $this->input->post('deliv_data');
            //insert order id
            $ord_id = $this->m_pemesanan->insert(generate_code($this->m_pemesanan->get_last_id(),7,'ORD-'), //order code 
                                                 date('Y-m-d H:i:s',strtotime($this->input->post('ord_fordate'))),
                                                 $current_time,
                                                 $this->isDelivery($deliv_data) ? DELIVERY : TAKEAWAY,
                                                 $this->isDelivery($deliv_data) ? $deliv_data['ord_delivaddress'] : FALSE,
                                                 $this->isDelivery($deliv_data) ? $deliv_data['ord_delivcity'] : FALSE,
                                                 $this->isDelivery($deliv_data) ? $deliv_data['ord_delivprovince'] : FALSE,
                                                 $this->isDelivery($deliv_data) ? $deliv_data['ord_delivzip'] : FALSE,
                                                 $subtotalItem,
                                                 $grandTotal,
                                                 $this->input->post('ord_discount') !== "" ? $this->input->post('ord_discount') : FALSE,
                                                 $this->isReservation($this->input->post('reservation')) ? RESERVASI : KATERING,
                                                 NOT_PAID,
                                                 $current_time,
                                                 $current_time
                                                );

            //insert to order menu
            foreach($this->input->post('order_item') as $menu){
                $menu_data = $this->m_menu->get("mnu_id = ".$menu['id'],"",1);
                $odm_id = $this->m_pemesananmenu->insert($menu_data->mnu_id,
                                               $ord_id,
                                               $menu['quantity'],
                                               $menu_data->mnu_price,
                                               intval($menu_data->mnu_price) * intval($menu['quantity']),
                                               $menu['note']
                                            );
                
                //calculate the additional item
                if(isset($menu['menu_additional'])){
                    foreach($menu['menu_additional'] as $additional){
                        $additional_data = $this->m_menutambahan->get("mad_id = ".$additional['origin_id'],"",1);
                        $this->m_pemesanantambahan->insert($odm_id,
                                                           $additional_data->mad_id,
                                                           $additional['quantity'],
                                                           intval($additional_data->mad_price) * intval($additional['quantity'])
                                                        );
                    }
                }
            }
            
            if($this->input->post('reservation') !== NULL){
                $data_reservation = $this->input->post('reservation');
                $this->m_pemesananreservasi->insert($ord_id,
                                                    $data_reservation['odr_table'],
                                                    $data_reservation['odr_start'],
                                                    date('Y-m-d H:i:s',strtotime(
                                                        get_valuesetting('reservationend_default').' minutes',
                                                        strtotime($data_reservation['odr_start']))),
                                                    $data_reservation['odr_people'],
                                                    PROCESS
                                                );
            }
            
            if($this->input->post('tax') !== NULL){
                //insert to tax order
                foreach($this->input->post('tax') as $tax){
                    $this->db->insert('order_tax',array('ort_order' => $ord_id, 'ort_tax' => $tax));
                }
            }
            
            //insert to invoice
            $total_invoice = array($grandTotal);
            
            if($this->isDP($this->input->post('inv_isdp'))){
                $min_dp = get_valuesetting('default_mindp');
                //default two invoice
                //TODO need create for multiple invoice
                $total_invoice = array();
                $dp_first = $grandTotal * (intval($min_dp)/100);
                $dp_final = $grandTotal - $dp_first;
                $total_invoice = array($dp_first,$dp_final);
            }
            $counter = 1;
            $first_duedate = date('Y-m-d H:i:s',strtotime(get_valuesetting('invoiceend_default'),
                                                strtotime($current_time)));
            $final_duedate = date('Y-m-d H:i:s',strtotime(get_valuesetting('invoiceend_finaldp'),
                                                strtotime($current_time)));
            
            foreach($total_invoice as $invoice_val){
                
                $this->m_pemesananinvoice->insert(generate_code($this->m_pemesananinvoice->get_last_id(),7,'INV-'),
                                                  $ord_id,
                                                  $this->input->post('inv_customer') !== "" ? 
                                                  $this->input->post('inv_customer') :
                                                  $this->createCustomerInfo($this->input->post('new_customer')),
                                                  $current_time,
                                                  $counter < 2 ? $first_duedate : $final_duedate,
                                                  $this->input->post('inv_paygateway'),
                                                  $this->isDP($this->input->post('inv_isdp')),
                                                  $counter < 2 ? get_valuesetting('default_mindp') : 100-intval(get_valuesetting('default_mindp')),
                                                  $counter < 2 ? get_valuesetting('default_mindp') : 100-intval(get_valuesetting('default_mindp')),
                                                  $invoice_val,
                                                  NOT_PAID,
                                                  $current_time,
                                                  $current_time
                );
                $counter++;
            }
            json_response('success','Sukses membuat order',
                        array( 'redir_url' => base_url().'backend/invoice'));
            
        }
        
        
    }

    private function createCustomerInfo($data_cust){
        if(!isset($data_cust)) return false;

        return $this->m_pelanggan->insert($data_cust['cst_name'],
                                             $data_cust['cst_phone'],
                                             FALSE,FALSE,FALSE,
                                             $data_cust['cst_address'],
                                             FALSE,
                                             FALSE,
                                             NO_CREDENTIAL,
                                             date('Y-m-d H:i:s'),
                                             date('Y-m-d H:i:s')
                                            );
    }

    private function isDelivery($deliv_data){
        return isset($deliv_data);
    }

    private function isReservation($reservation_data){
        return isset($reservation_data);
    }

    private function isDP($is_dp){
        return $is_dp === "true";
    }

    private function calculateAllItem($order_menu){
        if(!is_array($order_menu)) return false;
        $total = 0;
        foreach($order_menu as $menu){ //calculate menu 
            $menu_data = $this->m_menu->get("mnu_id = ".$menu['id'],"",1);
            if(intval($menu_data->mnu_minorder) <= intval($menu['quantity'])){
                $total += intval($menu_data->mnu_price) * intval($menu['quantity']);
            }else{
                return false;
            }
            //calculate the additional item
            if(isset($menu['menu_additional'])){
                foreach($menu['menu_additional'] as $additional){
                    $additional_data = $this->m_menutambahan->get("mad_id = ".$additional['origin_id'],"",1);
                    $total += intval($additional_data->mad_price) * intval($additional['quantity']);
                }
            }
        }
        return $total;
    }

    private function calculateAfterTax($grandTotal,$totalItem, $tax_id){
        if(!is_array($tax_id)) return $grandTotal;
        $tempTotal = $totalItem;
        foreach($tax_id as $tax){
            $tax_data = $this->m_pajak->get("tax_id = ".$tax,"",1);
            if($tax_data->tax_unit === "cash"){
                $totalItem += intval($tax_data->tax_value);

            }else{// if tax is percent
                $tax_calculate = $tempTotal * (intval($tax_data->tax_value)/100);
                $totalItem += $tax_calculate;
            }
        }
        return $totalItem; 
    }

    private function calcuateAfterDiscount($totalItem,$dsc_id){
        if($dsc_id == "") { return $totalItem; }

        $dsc_data = $this->m_diskon->get("dsc_id = ".$dsc_id,"",1);
        
        if($dsc_data->dsc_unit == "cash"){
            $totalItem -= intval($dsc_data->dsc_value);
        }else{// if tax is percent
            $dsc_calculate = $totalItem * (intval($dsc_data->dsc_value)/100);
            $totalItem -= $dsc_calculate;
        }
        return $totalItem;
    }
    


    
}