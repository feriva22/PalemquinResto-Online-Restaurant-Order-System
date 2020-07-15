<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/rapidrms/frontend/TemplateRms.php");

class Menu extends TemplateRms {

	public function __construct(){
		parent::__construct();
        $this->load->model(array('menu/MenuModel','customer/MCustomer','menu/OrderModel'));
        $this->load->library('cart');
    }
    
    public function index(){

        //get total of menu by menuType
        $paramMenuType  = (isset($_REQUEST['menuType']) ? $_REQUEST['menuType'] : "1");      //this is your passing parameter----- 
        $paramSearch = (isset($_REQUEST['search']) ? $_REQUEST['search'] : null);
        $filter = array(
            "menuType" => $paramMenuType //default wait need change $this->input->post("menu_type");
        );
        
        $this->load->library('pagination');
        
        $config['base_url'] = base_url().'Menu/index';
        $config['total_rows'] = (int)$this->MenuModel->get_totalMenu($filter);
        $config['suffix'] = '?'.http_build_query($_REQUEST, '', "&");
        $config["uri_segment"] = 3;  // uri paramete
        $config['per_page'] = 5;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        //bootstrap 4         
        $config['first_link']       = 'Pertama';
        $config['last_link']        = 'Akhir';
        $config['full_tag_open']    = '<div class="pagination page-list "><ul class=" list-inline text-right">';
        $config['full_tag_close']   = '</ul></div>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="active">';
        $config['cur_tag_close']    = '</li>';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']  = '</li>';
        $config['first_tag_open']   = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']  = '</li>';
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['menuType'] = (int) $paramMenuType;
        //get data from database limit  $config['per_page'] = 10; and start from $data['page'];
        list($data['dataMenu'],$query) = $this->MenuModel->listMenu((int)$data['page'],$config['per_page'],$paramSearch,$filter);
        $data['dataMenu'] = $data['dataMenu']->result();
        foreach($data['dataMenu'] as $row){
            $data_additional = $this->MenuModel->listMenuOptional(null,null,null,array('idmenu' => $row->mnu_id));
            $row->menu_additional = $data_additional->result();
        }
        $data['pagination'] = $this->pagination->create_links();

        //check reservation cart exist or not
        $data['isReservation'] = $this->check_cart_reservation($paramMenuType);

        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Daftar Menu";
        $this->data["css"] = NULL;
		$this->data["js"] = array('menuFrontend.js');
		$this->data["breadcrumb"] = TRUE;
        $this->data["content"] = "menu.php";
        $this->data["records"] = array(
            "data" =>  $data
        );       
        $this->data['with_footer'] = false;
        $this->loadView();
    }

    public function add_to_cart(){

        $filter = array(
            'idmenu' => $this->input->post('menu_id')
        );

        list($resultData, $sql) = $this->MenuModel->listMenu(null,null,null,$filter);

        if($resultData->num_rows() > 0){
            $result = $resultData->row();
            $data = array(
                'id' => $result->mnu_id,
                'name' => $result->mnu_name,
                'price' => floatval($result->mnu_price),
                'qty' => floatval($this->input->post('menu_qty')),
                'options' => array('idmenu' => $result->mnu_id, 'type' => 'common','note' => $this->input->post('menu_note'))
            );

            $rowId = $this->cart->insert($data);

            $dataMenuOpt = array();

            if(is_array($this->input->post('menu_opt')) ){
                foreach($this->input->post('menu_opt') as $menuOptItem){
                    $resultDataOpt = $this->MenuModel->listOptional(null,null,null,
                                                    array('idmenu_tambahan' => $menuOptItem['menuOpt_id']));
                    if($resultDataOpt->num_rows() > 0){
                        $result = $resultDataOpt->row();
                        $dataMenuOpt[] = array(
                            'id' => $result->mad_id,
                            'name' => $result->mad_name,
                            'price' => floatval($result->mad_price),
                            'qty' => floatval($menuOptItem['menuOpt_qty']),
                            'options' => array('idmenuOpt' => $result->mad_id, 'type' => 'optional', 'parent' => $rowId)
                        );
                    }
                }
                $this->cart->insert($dataMenuOpt);
            }
            
            //$this->cart->destroy();
            $this->load_cart(); 
            //var_dump($dataMenuOpt);
        }
    }

    public function add_reservation_cart(){
        $data = array(
            'id' => $this->input->post('idSeat'),
            'name' => 'Reserv meja no.'.$this->input->post('noSeat'),
            'price' => 0,
            'qty' => 1,
            'options' => array(
                'idSeat' => $this->input->post('idSeat'), 
                'type' => 'reservation',
                'date' => $this->input->post('dateReservation'),
                'time' => $this->input->post('timeReservation'),
                'people' => $this->input->post('people')
                )
        );
        $rowId = $this->cart->insert($data);
        echo json_encode(array('status'=> true,'message' => $rowId));
        exit();

    }

    function show_cart(){
        $output = '';

        foreach($this->cart->contents() as $item){
            $option = $this->cart->product_options($item['rowid']);
            if(isset($option['type']) && ($option['type'] == 'common' || $option['type'] == 'reservation')){
                $tot_option = 0;
                $kind_option = 0;
                foreach($this->cart->contents() as $menuOpt){
                    $option = $this->cart->product_options($menuOpt['rowid']);
                    if(isset($option['type']) && $option['type'] == 'optional' && $option['parent'] == $item['rowid']){
                        $tot_option += $menuOpt['price']*$menuOpt['qty'];
                        $kind_option++;
                    }
                }
                if($kind_option > 0){
                    $priceStr = 'Rp '.$item['price']*$item['qty'].'+'.$tot_option.'('.$kind_option.') Opsi';
                }else{
                    $priceStr = 'Rp '.$item['price']*$item['qty'];
                }

                $output .='
                    <li class="itemCart" data-rowid="'.$item['rowid'].'">
                    <div class="itemCartLabel">
                    <p >'.$item['qty'].'x '.$item['name'].'
                    <span class="icon-link"></i><i class="deleteCartItem fa fa-times"></i></span>
                    </p>
                    </div>
                    <p class="price">'.$priceStr.'</p></li>';
                    //<i class="updateCartItem fa fa-pencil"> for pencil edit icon
            }
        }
        if($this->cart->total_items() > 0){
            $output .='<li>
            <!-- list for total price-->
            <p>Total</p>
            <p class="price-total">Rp'. number_format($this->cart->total()).'</p>
            </li></ul>';
            $output .='
            <div class="checkout">
			<a href="'.base_url().'Menu/checkout" class="btn btn-default-red" id="actCheckout" ><i class="fa fa-shopping-cart"></i>Checkout</a>
			</div>';
        }else{
            $output .='<li><p>Anda belum memesan<p></li></ul>';
        }
        return $output;
    }

    function load_cart(){ //load data cart
        echo $this->show_cart();
    }

    function delete_all_cart(){ //fungsi untuk menghapus item cart
        $data = array();
        $data[] = array(
            'rowid' => $this->input->post('row_id'), 
            'qty' => 0, 
        );
        //delete for child
        foreach($this->cart->contents() as $item){
            $option = $this->cart->product_options($item['rowid']);
            if(isset($option['type']) && $option['type'] == 'optional' && $option['parent'] == $this->input->post('row_id')){
                $data[] =  array(
                    'rowid' => $item['rowid'],
                    'qty' => 0
                );
            }
        }
        $this->cart->update($data);
        echo $this->show_cart();
    }

    public function checkout(){

        if(!$this->session->userdata('logged_in')){
            $this->session->set_flashdata('alert', ['msg' => 'Silahkan Login atau Register akun terlebih dahulu','status' => 'error']);
            $this->session->set_userdata('last_page',base_url().'menu/checkout');   //redirect to checkout after login 
            return redirect('auth');
        }

        if($this->cart->total_items() < 1){
            return redirect('menu');
        }
        $check = $this->MCustomer->getCustomer(['cst_email' => $this->session->userdata('email'),'cst_status' => ACTIVE]);

        if($this->session->userdata('last_page') !== null){
            $this->session->unset_userdata('last_page');
        }


        $data = array();

        $data['time'] = date('Y-m-d H:i:s');
        $data['customer'] = $check->row();

        $data['isReservation'] = $this->has_reservation();
        $data['dp_info'] = $this->db->get_where('setting',array('stg_name' => 'default_mindp'))->row();
        $data['payment_method'] = $this->db->get_where('payment_gateway',array('pyg_status' => PUBLISH))->result();

        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Checkout";
        $this->data["css"] = array('loginRegis.css');;
		$this->data["js"] = array('checkout.js');
		$this->data["breadcrumb"] = TRUE;
        $this->data["content"] = "checkout.php";
        $this->data["records"] = array(
            "data" => $data
        );          
        $this->data["with_footer"] = false;
        $this->loadView();
    }

    public function checkout_act(){
        $this->form_validation->set_rules('cst_name', 'Nama Pemesanan', 'trim|required');   
        $this->form_validation->set_rules('cst_phone', 'Nomor Pemesan', 'trim|required');
        $this->form_validation->set_rules('ord_fordate','Pesanan untuk tanggal','required|trim');
        $this->form_validation->set_rules('ord_time','Pesanan untuk jam','required');
        $this->form_validation->set_rules('inv_delivaddress','alamat pengiriman','trim');
        $this->form_validation->set_rules('inv_isdp','Pembayaran','required');
        $this->form_validation->set_rules('inv_paygateway','Metode pembayaran','integer|required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->output->set_status_header('400'); //status bad request
            echo json_encode(array(
                'success' => false,
                'message' => validation_errors()
            ));
            exit();
        }

        $subtotalItem  = $this->cart->total();

        $delivAddress = $this->input->post('inv_delivaddress');

        //check are delivAddress has match on config
        if(get_valuesetting('allowed_deliveryaddr') !== "" && $delivAddress !== ""){
            $allowed_addr = explode(",",get_valuesetting('allowed_deliveryaddr'));
            $found = 0;
            foreach($allowed_addr as $addr){
                if(strpos(strtolower($delivAddress),strtolower(trim($addr)))===false){
                }
                else{
                    $found++;
                }
            }
            if($found == 0){
                $this->output->set_status_header('400'); //status bad request
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Maaf alamat yang anda masukkan tidak diperbolehkan saat ini'
                ));
                exit();
            }
        }

        $this->db->insert('order',array(
                                    'ord_code' => generate_code($this->OrderModel->get_lastorder_id(),7,'ORD-'),
                                    'ord_fordate' => date('Y-m-d H:i:s',strtotime($this->input->post('ord_fordate').' '.$this->input->post('ord_time'))),
                                    'ord_date' => date('Y-m-d H:i:s'),
                                    'ord_isdelivery' => $delivAddress === "" ? TAKEAWAY : DELIVERY,
                                    'ord_delivaddress' => $delivAddress === "" ? FALSE : $delivAddress,
                                    'ord_delivcity' => $delivAddress === "" ? FALSE : '',
                                    'ord_delivprovince' => $delivAddress === "" ? FALSE : '',
                                    'ord_subtotal' => $subtotalItem,
                                    'ord_total' => $subtotalItem,
                                    'ord_type' => $this->has_reservation() ? 2 : 1,
                                    'ord_status' => NOT_PAID,
                                    'ord_created' => date('Y-m-d H:i:s'),
                                    'ord_updated' => date('Y-m-d H:i:s')
                                ));
        $ord_id = $this->db->insert_id();

        //insert the item
        foreach($this->cart->contents() as $item){
            $option = $this->cart->product_options($item['rowid']);
            if(isset($option['type']) && $option['type'] == 'common'){
                 $this->db->insert('order_menu',array(
                                    'odm_menu' => $option['idmenu'],
                                    'odm_order' => $ord_id,
                                    'odm_quantity' => $item['qty'],
                                    'odm_price' => $item['price'],
                                    'odm_total' => intval($item['price']) * intval($item['qty'])
                ));
                $odm_id = $this->db->insert_id();

                foreach($this->cart->contents() as $item_additional){
                    $opt_additional = $this->cart->product_options($item_additional['rowid']);
                    if(isset($opt_additional['type']) && $opt_additional['type'] == 'optional'
                         && $opt_additional['parent'] == $item['rowid']){
                            //jika ada optionalnya
                            $data_mnuopt = $this->db->get_where('menu_additional',array(
                                                            'mad_id' => $item_additional['id']
                                            ))->row();
                            $this->db->insert('order_menuadditional',array(
                                    'oma_ordermenu' => $odm_id,
                                    'oma_menuadditional' => intval($item_additional['id']),
                                    'oma_quantity' => $item_additional['qty'],
                                    'oma_total' => intval($data_mnuopt->mad_price) * $item_additional['qty']
                            ));
                         }
               }
            }
            else if(isset($option['type']) && $option['type'] == 'reservation'){//insert fo reservation
                $this->db->insert('order_reservation',array(
                    'odr_order' => $ord_id,
                    'odr_table' => $option['idSeat'],
                    'odr_start' => date('Y-m-d H:i:s',strtotime($this->input->post('ord_fordate').' '.$this->input->post('ord_time'))),
                    'odr_end' => date('Y-m-d H:i:s', strtotime(
                        get_valuesetting('reservationend_default').' minutes',
                        strtotime($this->input->post('ord_fordate').' '.$this->input->post('ord_time')))),
                    'odr_people' => $option['people'],
                    'odr_status' => PROCESS
                    ));
            }
        }

        //insert to invoice
        $total_invoice = array($subtotalItem);
        if($this->input->post('inv_isdp') == 1){
            $min_dp = get_valuesetting('default_mindp');
            //default two invoice
            //TODO need create for multiple invoice
            $total_invoice = array();
            $dp_first = $subtotalItem * (intval($min_dp)/100);
            $dp_final = $subtotalItem - $dp_first;
            $total_invoice = array($dp_first,$dp_final);
        }

        $counter = 1;
        $first_duedate = date('Y-m-d H:i:s',strtotime(get_valuesetting('invoiceend_default'),
                                            strtotime(date('Y-m-d H:i:s'))));
        $final_duedate = date('Y-m-d H:i:s',strtotime(get_valuesetting('invoiceend_finaldp'),
                                            strtotime(date('Y-m-d H:i:s'))));

        foreach($total_invoice as $invoice_val){
            
            $this->db->insert('invoice',array(
                                'inv_code' => generate_code($this->OrderModel->get_lastinvoice_id(),7,'INV-'),
                                'inv_order' => $ord_id,
                                'inv_customer' => $this->session->userdata('id'),
                                'inv_date' => date('Y-m-d H:i:s'),
                                'inv_duedate' => $counter < 2 ? $first_duedate : $final_duedate,
                                'inv_paygateway' => $this->input->post('inv_paygateway'),
                                'inv_isdp' => $this->input->post('inv_isdp') == 1 ? 1 : NULL,
                                'inv_dp' => $this->input->post('inv_isdp') == 1 ? $counter < 2 ? get_valuesetting('default_mindp') : 100-intval(get_valuesetting('default_mindp')) : NULL,
                                'inv_dpvalue' => $this->input->post('inv_isdp') == 1 ? $counter < 2 ? get_valuesetting('default_mindp') : 100-intval(get_valuesetting('default_mindp')) : NULL,
                                'inv_total' => $invoice_val,
                                'inv_status' => NOT_PAID,
                                'inv_created' => date('Y-m-d H:i:s'),
                                'inv_updated' => date('Y-m-d H:i:s')
            ));
            $counter++;
        }

        $this->cart->destroy();

        echo json_encode(array(
                'success' => true,
                'message' => 'Pemesanan sukses' 
            ));
            exit();

    }

    function has_reservation(){
        foreach($this->cart->contents() as $item){
            $option = $this->cart->product_options($item['rowid']);
            if(isset($option['type']) && $option['type'] == 'reservation'){
                return true;
            }
        }
        return false;
    }

    //* option for check have cart for reservation or not */
    function check_cart_reservation($paramMenuType){
        if($paramMenuType !== "6"){
            return true;
        }

        foreach($this->cart->contents() as $item){
            $option = $this->cart->product_options($item['rowid']);
            if(isset($option['type']) && $option['type'] == 'reservation' && $paramMenuType === "6"){
                return true;
            }
        }
        return false;
    }
}