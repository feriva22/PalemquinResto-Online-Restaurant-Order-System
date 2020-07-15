<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/rapidrms/frontend/TemplateRms.php");

class Auth extends TemplateRms {

    public function __construct(){
        parent::__construct();
		$this->load->model(array('menu/MenuModel','customer/MCustomer'));
		$this->load->library('cart');
        $this->load->library('email');

    }

    public function index(){
        
        /*if($this->session->userdata('logged_in') === TRUE ){
            redirect('Customer');
        }*/
        $this->data["login_info"] = $this->session->all_userdata();
        $this->data["page_title"] = "Login/Register";
        $this->data["css"] = array('loginRegis.css');
		$this->data["js"] = NULL;
		$this->data["breadcrumb"] = TRUE;
        $this->data["content"] = "auth.php";
        $this->data["records"] = array();  
        $this->data['with_footer'] = false;
        $this->loadView();
    }

    //TODO edit for login customer
	public function login_act(){
		
		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('alert', ['msg' => 'Format input salah !','status' => 'error']);
			redirect('auth');
		}else {
			$email = $this->input->post('email');
			$password = password_hash($this->input->post('password'),PASSWORD_DEFAULT);

			$validate = $this->MCustomer->getCustomer(['cst_email' => $email,'cst_password' => $password]);
			if($validate->num_rows() > 0){
				$data = $validate->row_array();
				$name = $data['cst_name'];
				$email = $data['cst_email'];
				$sessdata = array(
                    'id' => $data['cst_id'],
					'username' => $name,
					'email' => $email,
					'logged_in' => TRUE
				);
				$this->session->set_userdata($sessdata);
                //login ok
                $this->session->set_flashdata('alert', ['msg' => 'Login Sukses','status' => 'success']);
				redirect('menu');

			} else {
				//login failed
                $this->session->set_flashdata('alert', ['msg' => 'Email atau Password salah','status' => 'error']);
				redirect('auth');
			}
        }
        
    }

    public function login_google(){
        if(!$this->input->is_ajax_request()) show_404();

		$id_token = $this->input->post("idtoken");

		if($id_token != NULL || $id_token != ""){
				
			// Include two files from google-php-client library in controller
			require_once APPPATH . "libraries/Google/autoload.php";
			include_once APPPATH . "libraries/Google/Client.php";
			include_once APPPATH . "libraries/Google/Service/Oauth2.php";

			// Create Client Request to access Google API
			$client = new Google_Client();
			$client->setApplicationName("Palemquinresto");
			$client->setClientId(GOOGLE_CLIENT_ID);
			$client->setClientSecret(GOOGLE_CLIENT_SECRET);
			//$client->setRedirectUri(GOOGLE_REDIR_URI);
			$client->setDeveloperKey(GOOGLE_API_KEY);
			$client->addScope("https://www.googleapis.com/auth/userinfo.email");

			// Send Client Request
			$objOAuthService = new Google_Service_Oauth2($client);

			//verify the id token
			$decoded_token = $client->verifyIdToken($id_token);
			
			if($decoded_token){ //if valid id token
				//$payload is parsed jwt token to incformation account
				$payload = $decoded_token->getAttributes()['payload'];
                $userid = $payload['sub'];
                
				$email = $payload['email'];
                
				$cst_filter = array(
					'cst_email' => $email,
					'cst_status' => ACTIVE
				);
                
                //check c
				//check on my database for current user
				$user_login = $this->MCustomer->getCustomer($cst_filter)->row();

				if($user_login !== NULL){
					$sessdata = array(
                        'id' => $user_login->cst_id,
                        'name' => $user_login->cst_name,
                        'email' => $user_login->cst_email,
                        'logged_in' => TRUE
                    );
					$this->session->set_userdata($sessdata);

					echo json_encode(array(
						'status' => 'success',
						'message' => 'Sukses Login','redir' => base_url()."customer/"
					));
					exit;
				}
				else{
                    //create user if user not in database
                    $usr_id = $this->MCustomer->addCustomer(array(
                                                                'cst_name' => $payload['name'],
                                                                'cst_email' => $email,
                                                                'cst_status' => ACTIVE,
                                                                'cst_created' => date('Y-m-d H:i:s'),
                                                                'cst_updated' => date('Y-m-d H:i:s')
                                                            ));
                    $user_login = $this->MCustomer->getCustomer(array('cst_id'=>$usr_id))->row();
                    
                    $sessdata = array(
                        'id' => $user_login->cst_id,
                        'name' => $user_login->cst_name,
                        'email' => $user_login->cst_email,
                        'logged_in' => TRUE
                    );
					$this->session->set_userdata($sessdata);       
                    
					echo json_encode(array(
						'status' => 'success',
						'message' => 'User sukses dibuat, Login...','redir' => base_url()."customer/"
					));
					exit;
				}
			}
			else {
				//invalid id token
				echo json_encode(array(
					'status' => 'error',
					'message' => 'Invalid id token'
				));
				exit;
			}
		}
		else{
			//invalid id token
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Invalid id token'
			));
			exit;
		}
    }
    
    
    public function register_act(){
        $this->form_validation->set_rules('username', 'Username','required|is_unique[user_pelanggan.username]');
        $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[user_pelanggan.email]');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('confpassword','Password','required|matches[password]');
        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', ['msg' => 'Format input anda salah !','status' => 'error']);
			return redirect('auth');
        }else{
            $data = array(
                'username' => $this->input->post('username'),
                'name' => $this->input->post('email'),
                'password' => md5($this->input->post('password')),
                'email_token' => md5($this->input->post('email')),
                'status' => 0
            );
            $this->MCustomer->addCustomer($data);

            $sessdata = array(
                'username' => $data['username'],
                'email' => $data['email'],
                'level' => 3,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($sessdata);
            $this->send_email_confirmation();
            return redirect('customer');
        }
    }

    public function send_email_confirmation(){
        if($this->session->userdata('logged_in') !== TRUE  || $this->session->userdata('level') !== 3){
            redirect('auth');
        }

        $check = $this->MCustomer->getCustomer(['cst_email' => $this->session->userdata('email')]);
        if($check->num_rows() > 0){
            $checkValid = $check->row();
            if((int) $checkValid->status === 0){
                $ci = get_instance();
                $config['protocol'] = "smtp";
                $config['smtp_host'] = "mailhog";
                $config['smtp_port'] = "1025";
                $config['smtp_user'] = "admin@palemquinresto.com";
                $config['smtp_pass'] = "@m04suguh";
                $config['charset'] = "utf-8";
                $config['mailtype'] = "html";
                $config['newline'] = "\r\n";
                $ci->email->initialize($config);
                $ci->email->from('admin@palemquinresto.com', 'Admin PalemquinResto');
                $list = array($this->session->userdata('email'));
		        $ci->email->to($list);
		        $ci->email->subject('Konfirmasi Akun Anda');
		        $ci->email->message('Silahkan klik link berikut untuk validasi akun anda '.base_url().'auth/confirm_email/'.$checkValid->email_token);
		        if($this->email->send()){
                    $this->session->set_flashdata('alert', ['msg' => 'Email konfirmasi telah terkirim','status' => 'success']);
		        }else{
                    $this->session->set_flashdata('alert', ['msg' => 'Email gagal terkirim, coba lagi','status' => 'error']);
                }
                redirect('auth/need_confirmation');
            }
        }
        else{
            redirect('auth');
        }
    }

    public function confirm_email($email_token=null){
        $check = $this->MCustomer->getCustomer(['byEmailToken' => $email_token]);
        if($check->num_rows() > 0){
            $checkValid = $check->row();

            $data = array(
                'email_token' => null,
                'status' => 1
            );
            $this->MCustomer->updValidEmail($checkValid->iduser_pelanggan,$data);
            $this->clear_session();
            $this->session->set_flashdata('alert', ['msg' => 'Akun telah terkonfirmasi,Silahkan login !','status' => 'success']);
            redirect('auth');   
        }else{
            $this->session->set_flashdata('alert', ['msg' => 'Kode verifikasi salah','status' => 'error']);
            redirect('auth/need_confirmation');   
        }
    }

    public function logout(){
        $this->clear_session();
        $this->session->set_flashdata('alert', ['msg' => 'Logout sukses !','status' => 'success']);
		redirect('auth');
    }

    private function clear_session(){
        $sessdata = array(
            'name','email',
            'id','logged_in',
        );
        $this->session->unset_userdata($sessdata);
    }

}