<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_pemesananmenu extends MY_Model {
    protected $pk_col = 'odm_id';
    protected $table_name = 'order_menu';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('odm_id');
            $this->db->select('odm_menu');
            $this->db->select('odm_order');
            $this->db->select('odm_quantity');
            $this->db->select('odm_price');
            $this->db->select('odm_total');
            $this->db->select('odm_note');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('odm_id');
            $this->db->select('odm_menu');
            $this->db->select('odm_order');
            $this->db->select('odm_quantity');
            $this->db->select('odm_price');
            $this->db->select('odm_total');
            $this->db->select('odm_note');

            $this->db->select('mnu_name');
        }
        $this->db->from($this->table_name);
        $this->db->join('menu','odm_menu = mnu_id');
    }

    public function insert(
                            $odm_menu = FALSE,
                            $odm_order = FALSE,
                            $odm_quantity = FALSE,
                            $odm_price = FALSE,
                            $odm_total = FALSE,
                            $odm_note = FALSE
                            ){
        $data = array();
        if($odm_menu !== FALSE) $data['odm_menu'] = $odm_menu;
        if($odm_order !== FALSE) $data['odm_order'] = $odm_order;
        if($odm_quantity !== FALSE) $data['odm_quantity'] = $odm_quantity;
        if($odm_price !== FALSE) $data['odm_price'] = $odm_price;
        if($odm_total !== FALSE) $data['odm_total'] = $odm_total;
        if($odm_note !== FALSE) $data['odm_note'] = trim($odm_note);
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $odm_id =FALSE,
                            $odm_menu = FALSE,
                            $odm_order = FALSE,
                            $odm_quantity = FALSE,
                            $odm_price = FALSE,
                            $odm_total = FALSE,
                            $odm_note = FALSE){
        $data = array();
        if($odm_menu !== FALSE) $data['odm_menu'] = $odm_menu;
        if($odm_order !== FALSE) $data['odm_order'] = $odm_order;
        if($odm_quantity !== FALSE) $data['odm_quantity'] = $odm_quantity;
        if($odm_price !== FALSE) $data['odm_price'] = $odm_price;
        if($odm_total !== FALSE) $data['odm_total'] = $odm_total;
        if($odm_note !== FALSE) $data['odm_note'] = trim($odm_note);
        
        return $this->db->update($this->table_name,$data,'odm_id = '.$odm_id);
    }



    


}