<?php    
defined('BASEPATH') OR exit('No direct script access allowed');
class HomeIndex extends CI_Controller {    
    public function index() {
        redirect('home');
        //$this->load->view('welcome_message');
    }    
}