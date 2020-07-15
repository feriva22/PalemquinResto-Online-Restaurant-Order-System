<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_menutambahan extends MY_Model {
    protected $pk_col = 'mad_id';
    protected $table_name = 'menu_additional';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('mad_id');
            $this->db->select('mad_name');
            $this->db->select('mad_price');
            $this->db->select('mad_status');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('mad_id');
            $this->db->select('mad_name');
            $this->db->select('mad_price');
            $this->db->select('mad_status');
        }
        $this->db->from($this->table_name);
    }

    public function insert( $mad_name   = FALSE,
                            $mad_price   = FALSE,
                            $mad_status = FALSE){
        $data = array();
        if($mad_name    !== FALSE) $data['mad_name'] = trim($mad_name);
        if($mad_price    !== FALSE) $data['mad_price'] = $mad_price;
        if($mad_status  !== FALSE) $data['mad_status'] = $mad_status;
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $mad_id     = FALSE,
                            $mad_name   = FALSE,
                            $mad_price   = FALSE,
                            $mad_status = FALSE){
        $data = array();
        if($mad_name    !== FALSE) $data['mad_name'] = trim($mad_name);
        if($mad_price    !== FALSE) $data['mad_price'] = $mad_price;
        if($mad_status  !== FALSE) $data['mad_status'] = $mad_status;
        return $this->db->update($this->table_name,$data,'mad_id = '.$mad_id);
    }



    


}