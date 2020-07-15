<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_diskon extends MY_Model {
    protected $pk_col = 'dsc_id';
    protected $table_name = 'discount';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('dsc_id');
            $this->db->select('dsc_name');
            $this->db->select('dsc_value');
            $this->db->select('dsc_unit');
            $this->db->select('dsc_expired');
            $this->db->select('dsc_status');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('dsc_id');
            $this->db->select('dsc_name');
            $this->db->select('dsc_value');
            $this->db->select('dsc_unit');
            $this->db->select('dsc_expired');
            $this->db->select('dsc_status');
        }
        $this->db->from($this->table_name);
    }

    public function insert( 
                            $dsc_name = FALSE,
                            $dsc_value = FALSE,
                            $dsc_unit = FALSE,
                            $dsc_expired = FALSE,
                            $dsc_status = FALSE
                            ){
        $data = array();
        if($dsc_name !== FALSE) $data['dsc_name'] = trim($dsc_name);
        if($dsc_value !== FALSE) $data['dsc_value'] = $dsc_value;
        if($dsc_unit !== FALSE) $data['dsc_unit'] = $dsc_unit;
        if($dsc_expired !== FALSE) $data['dsc_expired'] = $dsc_expired;
        if($dsc_status !== FALSE) $data['dsc_status'] = $dsc_status;

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $dsc_id = FALSE,
                            $dsc_name = FALSE,
                            $dsc_value = FALSE,
                            $dsc_unit = FALSE,
                            $dsc_expired = FALSE,
                            $dsc_status = FALSE){
        $data = array();
        if($dsc_name !== FALSE) $data['dsc_name'] = trim($dsc_name);
        if($dsc_value !== FALSE) $data['dsc_value'] = $dsc_value;
        if($dsc_unit !== FALSE) $data['dsc_unit'] = $dsc_unit;
        if($dsc_expired !== FALSE) $data['dsc_expired'] = $dsc_expired;
        if($dsc_status !== FALSE) $data['dsc_status'] = $dsc_status;
        
        return $this->db->update($this->table_name,$data,'dsc_id = '.$dsc_id);
    }



    


}