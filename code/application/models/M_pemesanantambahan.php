<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_pemesanantambahan extends MY_Model {
    protected $pk_col = 'oma_id';
    protected $table_name = 'order_menuadditional';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('oma_id');
            $this->db->select('oma_ordermenu');
            $this->db->select('oma_menuadditional');
            $this->db->select('oma_quantity');
            $this->db->select('oma_total');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('oma_id');
            $this->db->select('oma_ordermenu');
            $this->db->select('oma_menuadditional');
            $this->db->select('oma_quantity');
            $this->db->select('oma_total');

            $this->db->select('mad_name');
            $this->db->select('mad_price');
        }
        $this->db->from($this->table_name);
        $this->db->join('menu_additional','mad_id = oma_menuadditional');
        

    }

    public function insert(
                            $oma_ordermenu = FALSE,
                            $oma_menuadditional = FALSE,
                            $oma_quantity = FALSE,
                            $oma_total = FALSE
                            ){
        $data = array();
        if($oma_ordermenu !== FALSE) $data['oma_ordermenu'] = $oma_ordermenu;
        if($oma_menuadditional !== FALSE) $data['oma_menuadditional'] = $oma_menuadditional;
        if($oma_quantity !== FALSE) $data['oma_quantity'] = $oma_quantity;
        if($oma_total !== FALSE) $data['oma_total'] = $oma_total;
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $oma_id =FALSE,
                            $oma_ordermenu = FALSE,
                            $oma_menuadditional = FALSE,
                            $oma_quantity = FALSE,
                            $oma_total = FALSE){
        $data = array();
        if($oma_ordermenu !== FALSE) $data['oma_ordermenu'] = $oma_ordermenu;
        if($oma_menuadditional !== FALSE) $data['oma_menuadditional'] = $oma_menuadditional;
        if($oma_quantity !== FALSE) $data['oma_quantity'] = $oma_quantity;
        if($oma_total !== FALSE) $data['oma_total'] = $oma_total;
        return $this->db->update($this->table_name,$data,'oma_id = '.$oma_id);
    }



    


}