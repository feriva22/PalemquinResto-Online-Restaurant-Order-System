<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library(array('auth'));

	}
	
	public function index()
	{   
        if($this->auth->isLogin()){
            return redirect('backend/dashboard');
        }

		$data = array();

        $data['page_title'] = 'Login';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/login'
        );
        $data['assets_js'] = array();

        $this->load->view('backend/__base/header_login',$data);
        $this->load->view('backend/login/index');
        $this->load->view('backend/__base/footer_login',$data);
    }
    
    public function authenticate(){
        //only ajax is allowed
		if(!$this->input->is_ajax_request()) show_404();

        $res = $this->auth->backendLogin(USERNAME_PASSWORD);

        if(!$res){
            json_response('error','Username/password not found');
        }else{
            if(empty($res->stf_id))
                json_response('error',$res);
            else
                json_response('success','success login',array(
                                                    'redir'   => 'backend/dashboard'));
        }
        

    }

    public function logout(){
        if($this->auth->logout()){
            $this->auth->showBackendLoginForm();
        }
        return false;
    }
}
