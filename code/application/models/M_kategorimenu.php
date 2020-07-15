<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategorimenu extends MY_Model {
    protected $pk_col = 'mnc_id';
    protected $table_name = 'menu_category';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('mnc_id');
            $this->db->select('mnc_name');
            $this->db->select('mnc_status');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('mnc_id');
            $this->db->select('mnc_name');
            $this->db->select('mnc_status');
        }
        $this->db->from($this->table_name);
    }

    public function insert( $mnc_name   = FALSE,
                            $mnc_status = FALSE){
        $data = array();
        if($mnc_name    !== FALSE) $data['mnc_name'] = trim($mnc_name);
        if($mnc_status  !== FALSE) $data['mnc_status'] = $mnc_status;
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $mnc_id     = FALSE,
                            $mnc_name   = FALSE,
                            $mnc_status = FALSE){
        $data = array();
        if($mnc_name    !== FALSE) $data['mnc_name'] = trim($mnc_name);
        if($mnc_status  !== FALSE) $data['mnc_status'] = $mnc_status;
        return $this->db->update($this->table_name,$data,'mnc_id = '.$mnc_id);
    }



    


}