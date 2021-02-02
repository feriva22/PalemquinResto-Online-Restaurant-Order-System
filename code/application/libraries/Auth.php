<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Auth
{

    protected $CI;
    private $user = null;
    private $userID = null;
    private $userName = null;
    private $userGroup = null;
    private $password = null;
    private $loginStatus = false;

    private $auth_staff_db = null;
    private $auth_staffgroup_db = null;
    private $auth_staffgroupacc_db = null;
    private $auth_staffgroupacc_prefix = null;
    private $auth_staff_prefix = null;
    private $auth_user_pk = null;

    private $auth_moduleaccess_db = null;
    private $auth_moduleaccess_prefix = null;
    private $auth_module_db = null;
    private $auth_module_prefix = null;

    private $current_module = null;
    private $permission = null;

    /**
     * Constructor of class auth
     */
    public function __construct()
    {
        $this->CI = &get_instance();
        //set the config
        $this->auth_staff_db                = $this->CI->config->item('auth_staff_db');
        $this->auth_staff_prefix            = $this->CI->config->item('auth_staff_prefix');
        $this->auth_staffgroup_db           = $this->CI->config->item('auth_staffgroup_db');
        $this->auth_staffgroupacc_db        = $this->CI->config->item('auth_staffgroupacc_db');
        $this->auth_staffgroupacc_prefix    = $this->CI->config->item('auth_staffgroupacc_prefix');
        $this->auth_user_pk                 = $this->CI->config->item('auth_user_pk');

        $this->auth_moduleaccess_db         = $this->CI->config->item('auth_moduleaccess_db');
        $this->auth_moduleaccess_prefix     = $this->CI->config->item('auth_moduleaccess_prefix');
        $this->auth_module_db               = $this->CI->config->item('auth_module_db');
        $this->auth_module_prefix           = $this->CI->config->item('auth_module_prefix');

        $this->init();
    }

    /**
     * Initialization class auth
     */
    protected function init()
    {
        if ($this->CI->session->has_userdata("userID") && $this->CI->session->loginStatus) {
            $this->userID = $this->CI->session->userID;
            $this->userName = $this->CI->session->userName;
            $this->userGroup = $this->CI->session->userGroup;
            $this->loginStatus = true;
        }
        return;
    }

    /**
     * Show backend login form
     */
    public function showBackendLoginForm()
    {
        return redirect('backend/login');
    }

    /**
     * Show backend access denied page
     */
    public function showBackendAccessDenied()
    {
        //$this->CI->output->set_status_header('401');
        $data['page_title'] = 'Access Denied';

        echo $this->CI->load->view('backend/__base/header_dashboard', $data, TRUE);
        echo $this->CI->load->view('backend/__base/sidebar', $data, TRUE);
        echo $this->CI->load->view('backend/not_authorized/index', null, TRUE);
        echo $this->CI->load->view('backend/__base/footer_dashboard', $data, true);
        exit;
    }

    /**
     * Handle backend login
     *
     */
    public function backendLogin($method)
    {
        if ($this->validate($method)) {
            $this->user = $this->credentialStaff($this->userName, $this->password);
            if ($this->user) {
                $this->set_lastloginstaff($this->userName);
                $this->setUser($this->auth_staff_prefix);
                return $this->user;
            } else {
                return false;
            }
        } else {
            return validation_errors();
        }
    }

    /**
     * run form_validation for validation login credentials
     */
    protected function validate($method)
    {
        $this->CI->load->library('form_validation');
        if ($method == USERNAME_PASSWORD) {
            $this->CI->form_validation->set_rules('username', 'User Name', 'required');
            $this->CI->form_validation->set_rules('password', 'Password', 'required');

            if ($this->CI->form_validation->run()) {
                $this->userName = $this->CI->input->post('username', TRUE);
                $this->password = $this->CI->input->post('password', TRUE);
                return true;
            }
            return false;
        }
    }

    /**
     * set last login staff
     * 
     */
    protected function set_lastloginstaff($userName)
    {
        $user = $this->CI->db->get_where($this->auth_staff_db, array(
            "stf_username" => $userName,
            "stf_status !=" => DELETED
        ))->row(0);
        if ($user) {
            return $this->CI->db->update(
                $this->auth_staff_db,
                array("stf_lastlogin " => date('Y-m-d H:i:s')),
                "stf_id = " . $user->{$this->auth_staff_prefix . 'id'}
            );
        }
        return false;
    }
    /**
     * check credential for staff
     */
    protected function credentialStaff($userName, $password, $email = null)
    {
        //check if email oauth authentication

        $user = $this->CI->db->get_where($this->auth_staff_db, array(
            "stf_username" => $userName,
            "stf_status !=" => DELETED
        ))->row(0);
        //password_verify is plugin from php                                                                    
        if ($user && password_verify($password, $user->{$this->auth_staff_prefix . 'password'})) {
            return $user;
        }
        return false;
    }

    /**
     * get user staff group
     */
    protected function get_staff_group($userID)
    {

        $group = $this->CI->db->get_where($this->auth_staffgroupacc_db, array(
            $this->auth_staffgroupacc_prefix . '' . $this->auth_staff_db => $userID
        ))->row(0);

        if ($group !== NULL) {
            return $group->{$this->auth_staffgroupacc_prefix . '' . $this->auth_staffgroup_db};
        }
        return false;
    }

    /**
     * set current login user to session for authenti
     */
    protected function setUser($prefix)
    {
        $this->userID = $this->user->{$prefix . '' . $this->auth_user_pk};

        if ($prefix == 'stf_') {
            $this->userGroup = $this->get_staff_group($this->userID);
            if (!$this->userGroup) {
                $this->userGroup = CASHIER;
            }
        } else {
            $this->userGroup = CUSTOMER;
        }

        $this->CI->session->set_userdata(array(
            "userID" => $this->user->{$prefix . '' . $this->auth_user_pk},
            "userName" => $this->user->{$prefix . 'name'},
            "userGroup" => $this->userGroup,
            "loginStatus" => true
        ));
    }


    /**
     * check login status
     */
    public function isLogin()
    {
        return $this->loginStatus;
    }

    /**
     * determine if current user is authenticated
     */
    public function authenticate()
    {
        if (!$this->isLogin()) {
            if ($this->CI->uri->segment(1) === 'backend') {
                $this->showBackendLoginForm();
                return false;
            }
        }

        return true;
    }

    /**
     * get User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Read authenticated user ID
     */
    public function getUserid()
    {
        return $this->userID;
    }

    /**
     * Read authenticated username
     */
    public function getUsername()
    {
        return $this->userName;
    }

    /**
     * Read authenticated group
     */
    public function getUsergroup()
    {
        return $this->userGroup;
    }

    /**
     * Logout current user
     */
    public function logout()
    {
        $this->CI->session->unset_userdata(array("userID", "userName", "loginStatus"));
        $this->CI->session->sess_destroy();
        return true;
    }

    /**
     * Set current module
     */
    public function set_module($name)
    {
        $this->current_module = $name;
    }

    /**
     * Check permission group with spesific module on db
     * v.1 just for one group only
     */
    protected function check_permission($module, $group)
    {
        return $this->CI->db->join(
            $this->auth_moduleaccess_db,
            $this->auth_moduleaccess_prefix . 'module = ' .
                $this->auth_module_prefix . 'id'
        )
            ->where($this->auth_moduleaccess_prefix . ''
                . $this->auth_staffgroup_db, $group)
            ->get_where($this->auth_module_db, array(
                $this->auth_module_prefix . 'name' => $module
            ))
            ->row(0);
    }

    /**
     * check permission on current module
     * v.1 just for one group only
     */
    public function authorize()
    {
        $res = $this->check_permission($this->current_module, $this->getUsergroup());

        if ($res) {
            $access = new stdClass();
            $access->create    = intval($res->{$this->auth_moduleaccess_prefix . 'create'});
            $access->read      = intval($res->{$this->auth_moduleaccess_prefix . 'read'});
            $access->update    = intval($res->{$this->auth_moduleaccess_prefix . 'update'});
            $access->delete    = intval($res->{$this->auth_moduleaccess_prefix . 'delete'});

            $this->permission = $access;
        }
    }

    /**
     * show permission on current module
     */
    public function all_permission()
    {
        return $this->permission;
    }

    /**
     * check current user have access create for current module
     */
    protected function can_create()
    {
        return (is_exist($this->permission)) ? $this->permission->create : 0;
    }

    /**
     * check current user have access read for current module
     */
    protected function can_read()
    {

        return (is_exist($this->permission)) ? $this->permission->read : 0;
    }

    /**
     * check current user have access update for current module
     */
    protected function can_update()
    {
        return (is_exist($this->permission)) ? $this->permission->update : 0;
    }

    /**
     * check current user have access delete for current module
     */
    protected function can_delete()
    {
        return (is_exist($this->permission)) ? $this->permission->delete : 0;
    }

    /**
     * set the access of method to create
     */
    public function set_access_create()
    {
        if (!$this->can_create()) {
            $this->showBackendAccessDenied();
        }
    }

    /**
     * set the access of method to read
     */
    public function set_access_read()
    {
        if (!$this->can_read()) {
            $this->showBackendAccessDenied();
        }
    }

    /**
     * set the access of method to update
     */
    public function set_access_update()
    {
        if (!$this->can_update()) {
            return $this->showBackendAccessDenied();
        }
    }

    /**
     * set the access of method to delete
     */
    public function set_access_delete()
    {
        if (!$this->can_delete()) {
            return $this->showBackendAccessDenied();
        }
    }
}
