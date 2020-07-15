<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TemplateRms extends CI_Controller {
    
	public $data = array();
    public $template = 'takeaway';

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	public function loadView()
	{
		$this->load->view('rapidrms/frontend/takeaway-template/template',$this->data);
	}
}
