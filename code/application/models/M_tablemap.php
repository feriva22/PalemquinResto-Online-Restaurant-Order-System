<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_tablemap extends MY_Model {
    protected $pk_col = 'tbm_id';
    protected $table_name = 'table_map';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('tbm_id');
            $this->db->select('tbm_name');
            $this->db->select('tbm_max');
            $this->db->select('tbm_min');
            $this->db->select('tbm_attr');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('tbm_id');
            $this->db->select('tbm_name');
            $this->db->select('tbm_max');
            $this->db->select('tbm_min');
            $this->db->select('tbm_attr');
        }
        $this->db->from($this->table_name);
        

    }

    public function insert( $tbm_id   = FALSE,
                            $tbm_name = FALSE,
                            $tbm_max = FALSE,
                            $tbm_min = FALSE,
                            $tbm_attr = FALSE
                            ){
        $data = array();
        if($tbm_id !== FALSE) $data['tbm_id'] = $tbm_id;
        if($tbm_name !== FALSE) $data['tbm_name'] = trim($tbm_name);
        if($tbm_max !== FALSE) $data['tbm_max'] = $tbm_max;
        if($tbm_min !== FALSE) $data['tbm_min'] = intval($tbm_min);
        if($tbm_attr !== FALSE) $data['tbm_attr'] = trim($tbm_attr);

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update(  $tbm_id = FALSE,
                            $tbm_name = FALSE,
                            $tbm_max = FALSE,
                            $tbm_min = FALSE,
                            $tbm_attr = FALSE){
        $data = array();
        if($tbm_name !== FALSE) $data['tbm_name'] = trim($tbm_name);
        if($tbm_max !== FALSE) $data['tbm_max'] = $tbm_max;
        if($tbm_min !== FALSE) $data['tbm_min'] = intval($tbm_min);
        if($tbm_attr !== FALSE) $data['tbm_attr'] = trim($tbm_attr);
        
        return $this->db->update($this->table_name,$data,'tbm_id = '.$tbm_id);
    }

    public function erase(){
        $this->db->empty_table($this->table_name);
    }



    


}