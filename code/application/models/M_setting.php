<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_setting extends MY_Model {
    protected $pk_col = 'stg_name';
    protected $table_name = 'setting';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('stg_name');
            $this->db->select('stg_value');
            $this->db->select('stg_description');
            
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('stg_name');
            $this->db->select('stg_value');
            $this->db->select('stg_description');
        }
        $this->db->from($this->table_name);
    }

    public function insert( 
                            $stg_name = FALSE,
                            $stg_value = FALSE,
                            $stg_description = FALSE
                            ){
        $data = array();
        if($stg_name !== FALSE) $data['stg_name'] = trim($stg_name);
        if($stg_value !== FALSE) $data['stg_value'] = trim($stg_value);
        if($stg_description !== FALSE) $data['stg_description'] = trim($stg_description);
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $stg_name = FALSE,
                            $stg_value = FALSE,
                            $stg_description = FALSE){
        $data = array();
        if($stg_value !== FALSE) $data['stg_value'] = trim($stg_value);
        if($stg_description !== FALSE) $data['stg_description'] = trim($stg_description);
        
        return $this->db->update($this->table_name,$data,'stg_name = \''.$stg_name.'\'');
    }



    


}