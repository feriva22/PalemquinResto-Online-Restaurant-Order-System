<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_paygateway extends MY_Model {
    protected $pk_col = 'pyg_id';
    protected $table_name = 'payment_gateway';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('pyg_id');
            $this->db->select('pyg_name');
            $this->db->select('pyg_detail');
            $this->db->select('pyg_type');            
            $this->db->select('pyg_status');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('pyg_id');
            $this->db->select('pyg_name');
            $this->db->select('pyg_detail');
            $this->db->select('pyg_type');            
            $this->db->select('pyg_status');
        }
        $this->db->from($this->table_name);
    }

    public function insert(
                            $pyg_name = FALSE,
                            $pyg_detail = FALSE,
                            $pyg_type = FALSE,
                            $pyg_status = FALSE
                        ){
        $data = array();
        if($pyg_name !== FALSE) $data['pyg_name'] = trim($pyg_name);
        if($pyg_detail !== FALSE) $data['pyg_detail'] = trim($pyg_detail);
        if($pyg_type !== FALSE) $data['pyg_type'] = $pyg_type;
        if($pyg_status !== FALSE) $data['pyg_status'] = $pyg_status;
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $pyg_id     = FALSE,
                            $pyg_name = FALSE,
                            $pyg_detail = FALSE,
                            $pyg_type = FALSE,
                            $pyg_status = FALSE){
        $data = array();
        if($pyg_name !== FALSE) $data['pyg_name'] = trim($pyg_name);
        if($pyg_detail !== FALSE) $data['pyg_detail'] = trim($pyg_detail);
        if($pyg_type !== FALSE) $data['pyg_type'] = $pyg_type;
        if($pyg_status !== FALSE) $data['pyg_status'] = $pyg_status;
        return $this->db->update($this->table_name,$data,'pyg_id = '.$pyg_id);
    }



    


}