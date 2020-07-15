<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/rapidrms/frontend/TemplateRms.php");

class Home extends TemplateRms {

	public function __construct(){
		parent::__construct();
		$this->load->model(array('menu/MenuModel','customer/MCustomer'));
		$this->load->library('cart');
		$this->load->library('email');

	}

	public function index()
	{
		$this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Beranda";
        $this->data["css"] = NULL;
		$this->data["js"] = NULL;
		$this->data["breadcrumb"] = TRUE;
		$this->data["content"] = "home.php";
		$this->data["with_footer"] = true;
        $this->data["records"] = array();       
        $this->loadView();
	}



}
