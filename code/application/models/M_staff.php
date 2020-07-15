<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_staff extends MY_Model {
    protected $pk_col = 'stf_id';
    protected $table_name = 'staff';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('stf_id');
            $this->db->select('sdg_name AS stf_group');
            $this->db->select('stf_name');
            $this->db->select('stf_username');
            $this->db->select('stf_email');
            $this->db->select('stf_password');
            $this->db->select('stf_lastlogin');
            $this->db->select('stf_status');
            $this->db->select('stf_created');
            $this->db->select('stf_updated');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('stf_id');
            $this->db->select('sga_staffgroup AS stf_group');
            $this->db->select('stf_name');
            $this->db->select('stf_username');
            $this->db->select('stf_email');
            $this->db->select('stf_lastlogin');
            $this->db->select('stf_status');
            $this->db->select('stf_created');
            $this->db->select('stf_updated');
        }
        $this->db->from($this->table_name);
        //$this->db->from('staffgroupaccess');
        $this->db->join('staffgroupaccess', 'stf_id = sga_staff');
        $this->db->join('staffgroup', 'sga_staffgroup = sdg_id');

    }

    public function insert( 
                            $stf_name    = FALSE,
                            $stf_username    = FALSE,
                            $stf_email   = FALSE,
                            $stf_password = FALSE,
                            $stf_lastlogin   = FALSE,
                            $stf_status  = FALSE,
                            $stf_created    = FALSE,
                            $stf_updated    = FALSE
                            ){
        $data = array();
        if($stf_name   !== FALSE) $data['stf_name'] = trim($stf_name);
        if($stf_username   !== FALSE) $data['stf_username'] = trim($stf_username);
        if($stf_email  !== FALSE) $data['stf_email'] = trim($stf_email);
        if($stf_password  !== FALSE) $data['stf_password'] = $stf_password;
        if($stf_lastlogin  !== FALSE) $data['stf_lastlogin'] = $stf_lastlogin;
        if($stf_status !== FALSE) $data['stf_status'] = $stf_status;
        if($stf_created   !== FALSE) $data['stf_created'] = $stf_created;
        if($stf_updated   !== FALSE) $data['stf_updated'] = $stf_updated;

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $stf_id = FALSE,
                            $stf_name    = FALSE,
                            $stf_username    = FALSE,
                            $stf_email   = FALSE,
                            $stf_password = FALSE,
                            $stf_lastlogin   = FALSE,
                            $stf_status  = FALSE,
                            $stf_created    = FALSE,
                            $stf_updated    = FALSE){
        $data = array();
        if($stf_name   !== FALSE) $data['stf_name'] = trim($stf_name);
        if($stf_username   !== FALSE) $data['stf_username'] = trim($stf_username);
        if($stf_email  !== FALSE) $data['stf_email'] = trim($stf_email);
        if($stf_password  !== FALSE) $data['stf_password'] = $stf_password;
        if($stf_lastlogin  !== FALSE) $data['stf_lastlogin'] = $stf_lastlogin;
        if($stf_status !== FALSE) $data['stf_status'] = $stf_status;
        if($stf_created   !== FALSE) $data['stf_created_date'] = $stf_created_date;
        if($stf_updated   !== FALSE) $data['stf_updated'] = $stf_updated;
        
        return $this->db->update($this->table_name,$data,'stf_id = '.$stf_id);
    }



    


}