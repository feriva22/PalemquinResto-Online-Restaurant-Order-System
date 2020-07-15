<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_pajak extends MY_Model {
    protected $pk_col = 'tax_id';
    protected $table_name = 'tax';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('tax_id');
            $this->db->select('tax_name');
            $this->db->select('tax_description');
            $this->db->select('tax_value');
            $this->db->select('tax_unit');
            $this->db->select('tax_status');
            $this->db->select('tax_created');
            $this->db->select('tax_updated');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('tax_id');
            $this->db->select('tax_name');
            $this->db->select('tax_description');
            $this->db->select('tax_value');
            $this->db->select('tax_unit');
            $this->db->select('tax_status');
            $this->db->select('tax_created');
            $this->db->select('tax_updated');
        }
        $this->db->from($this->table_name);
    }

    public function insert( 
                            $tax_name = FALSE,
                            $tax_description = FALSE,
                            $tax_value = FALSE,
                            $tax_unit = FALSE,
                            $tax_status = FALSE,
                            $tax_created = FALSE,
                            $tax_updated = FALSE
                            ){
        $data = array();
        if($tax_name   !== FALSE) $data['tax_name'] = trim($tax_name);
        if($tax_description   !== FALSE) $data['tax_description'] = trim($tax_description);
        if($tax_value  !== FALSE) $data['tax_value'] = intval($tax_value);
        if($tax_unit  !== FALSE) $data['tax_unit'] = intval($tax_unit);
        if($tax_status !== FALSE) $data['tax_status'] = intval($tax_status);
        if($tax_created   !== FALSE) $data['tax_created'] = trim($tax_created);
        if($tax_updated   !== FALSE) $data['tax_updated'] = trim($tax_updated);

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( 
                            $tax_id = FALSE,
                            $tax_name = FALSE,
                            $tax_description = FALSE,
                            $tax_value = FALSE,
                            $tax_unit = FALSE,
                            $tax_status = FALSE,
                            $tax_created = FALSE,
                            $tax_updated = FALSE){
        $data = array();
        if($tax_name   !== FALSE) $data['tax_name'] = trim($tax_name);
        if($tax_description   !== FALSE) $data['tax_description'] = trim($tax_description);
        if($tax_value  !== FALSE) $data['tax_value'] = intval($tax_value);
        if($tax_unit  !== FALSE) $data['tax_unit'] = intval($tax_unit);
        if($tax_status !== FALSE) $data['tax_status'] = intval($tax_status);
        if($tax_created   !== FALSE) $data['tax_created'] = trim($tax_created);
        if($tax_updated   !== FALSE) $data['tax_updated'] = trim($tax_updated);
        
        return $this->db->update($this->table_name,$data,'tax_id = '.$tax_id);
    }
}