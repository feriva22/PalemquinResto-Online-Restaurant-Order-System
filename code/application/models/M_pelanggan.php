<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pelanggan extends MY_Model {
    protected $pk_col = 'cst_id';
    protected $table_name = 'customer';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('cst_id');
            $this->db->select('cst_name');
            $this->db->select('cst_phone');
            $this->db->select('cst_email');
            $this->db->select('cst_birthday');
            $this->db->select('cst_gender');
            $this->db->select('cst_address');
            $this->db->select('cst_username');
            $this->db->select('cst_password');
            $this->db->select('cst_status');
            $this->db->select('cst_created');
            $this->db->select('cst_updated');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('cst_id');
            $this->db->select('cst_name');
            $this->db->select('cst_phone');
            $this->db->select('cst_email');
            $this->db->select('cst_birthday');
            $this->db->select('cst_gender');
            $this->db->select('cst_address');
            $this->db->select('cst_username');
            $this->db->select('cst_status');
            $this->db->select('cst_created');
            $this->db->select('cst_updated');
        }
        $this->db->from($this->table_name);
    }

    public function insert( 
                            $cst_name = FALSE,
                            $cst_phone = FALSE,
                            $cst_email = FALSE,
                            $cst_birthday = FALSE,
                            $cst_gender = FALSE,
                            $cst_address = FALSE,
                            $cst_username = FALSE,
                            $cst_password = FALSE,
                            $cst_status = FALSE,
                            $cst_created = FALSE,
                            $cst_updated = FALSE
                            ){
        $data = array();
        if($cst_name   !== FALSE) $data['cst_name'] = trim($cst_name);
        if($cst_phone   !== FALSE) $data['cst_phone'] = trim($cst_phone);
        if($cst_email  !== FALSE) $data['cst_email'] = trim($cst_email);
        if($cst_birthday  !== FALSE) $data['cst_birthday'] = trim($cst_birthday);
        if($cst_gender  !== FALSE) $data['cst_gender'] = intval($cst_gender);
        if($cst_address  !== FALSE) $data['cst_address'] = trim($cst_address);
        if($cst_username  !== FALSE) $data['cst_username'] = trim($cst_username);
        if($cst_password  !== FALSE) $data['cst_password'] = trim($cst_password);
        if($cst_status !== FALSE) $data['cst_status'] = intval($cst_status);
        if($cst_created   !== FALSE) $data['cst_created'] = trim($cst_created);
        if($cst_updated   !== FALSE) $data['cst_updated'] = trim($cst_updated);

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $cst_id = FALSE,
                            $cst_name = FALSE,
                            $cst_phone = FALSE,
                            $cst_email = FALSE,
                            $cst_birthday = FALSE,
                            $cst_gender = FALSE,
                            $cst_address = FALSE,
                            $cst_username = FALSE,
                            $cst_password = FALSE,
                            $cst_status = FALSE,
                            $cst_created = FALSE,
                            $cst_updated = FALSE
                            ){
        $data = array();
        if($cst_name   !== FALSE) $data['cst_name'] = trim($cst_name);
        if($cst_phone   !== FALSE) $data['cst_phone'] = trim($cst_phone);
        if($cst_email  !== FALSE) $data['cst_email'] = trim($cst_email);
        if($cst_birthday  !== FALSE) $data['cst_birthday'] = trim($cst_birthday);
        if($cst_gender  !== FALSE) $data['cst_gender'] = intval($cst_gender);
        if($cst_address  !== FALSE) $data['cst_address'] = trim($cst_address);
        if($cst_username  !== FALSE) $data['cst_username'] = trim($cst_username);
        if($cst_password  !== FALSE) $data['cst_password'] = trim($cst_password);
        if($cst_status !== FALSE) $data['cst_status'] = intval($cst_status);
        if($cst_created   !== FALSE) $data['cst_created'] = trim($cst_created);
        if($cst_updated   !== FALSE) $data['cst_updated'] = trim($cst_updated);
        
        return $this->db->update($this->table_name,$data,'cst_id = '.$cst_id);
    }



    


}