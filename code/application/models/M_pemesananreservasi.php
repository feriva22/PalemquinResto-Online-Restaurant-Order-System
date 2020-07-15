<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_pemesananreservasi extends MY_Model {
    protected $pk_col = 'ord_id';
    protected $table_name = 'order_reservation';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('odr_id');
            $this->db->select('odr_order');
            $this->db->select('odr_table');
            $this->db->select('odr_start');
            $this->db->select('odr_end');
            $this->db->select('odr_people');
            $this->db->select('odr_status');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('odr_id');
            $this->db->select('odr_order');
            $this->db->select('odr_table');
            $this->db->select('odr_start');
            $this->db->select('odr_end');
            $this->db->select('odr_people');
            $this->db->select('odr_status');

            $this->db->select('tbm_name');
        }
        $this->db->from($this->table_name);
        $this->db->from('table_map','odr_table = tbm_id','left');
        

    }

    public function insert(
                            $odr_order = FALSE,
                            $odr_table = FALSE,
                            $odr_start = FALSE,
                            $odr_end = FALSE,
                            $odr_people = FALSE,
                            $odr_status = FALSE
                            ){
        $data = array();
        if($odr_order !== FALSE) $data['odr_order'] = $odr_order;
        if($odr_table !== FALSE) $data['odr_table'] = $odr_table;
        if($odr_start !== FALSE) $data['odr_start'] = trim($odr_start);
        if($odr_end !== FALSE) $data['odr_end'] = trim($odr_end);
        if($odr_people !== FALSE) $data['odr_people'] = intval($odr_people);
        if($odr_status !== FALSE) $data['odr_status'] = $odr_status;
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $odr_id =FALSE,
                            $odr_order = FALSE,
                            $odr_table = FALSE,
                            $odr_start = FALSE,
                            $odr_end = FALSE,
                            $odr_people = FALSE,
                            $odr_status = FALSE){
        $data = array();
        if($odr_order !== FALSE) $data['odr_order'] = $odr_order;
        if($odr_table !== FALSE) $data['odr_table'] = $odr_table;
        if($odr_start !== FALSE) $data['odr_start'] = trim($odr_start);
        if($odr_end !== FALSE) $data['odr_end'] = trim($odr_end);
        if($odr_people !== FALSE) $data['odr_people'] = $odr_people;
        if($odr_status !== FALSE) $data['odr_status'] = $odr_status;
        
        return $this->db->update($this->table_name,$data,'odr_id = '.$odr_id);
    }



    


}