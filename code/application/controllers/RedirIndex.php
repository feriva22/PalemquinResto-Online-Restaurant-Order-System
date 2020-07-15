<?php    
defined('BASEPATH') OR exit('No direct script access allowed');
class RedirIndex extends CI_Controller {    
    public function index() {
        redirect('backend');
    }    
}