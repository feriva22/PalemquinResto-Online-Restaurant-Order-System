<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_pemesanan extends MY_Model {
    protected $pk_col = 'ord_id';
    protected $table_name = 'order';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('ord_id');
            $this->db->select('ord_code');
            $this->db->select('ord_fordate');
            $this->db->select('ord_date');
            $this->db->select('ord_isdelivery');
            $this->db->select('ord_delivaddress');   
            $this->db->select('ord_delivcity');
            $this->db->select('ord_delivprovince');
            $this->db->select('ord_delivzip');
            $this->db->select('ord_subtotal');
            $this->db->select('ord_total');
            $this->db->select('ord_discount');
            $this->db->select('ord_type');
            $this->db->select('ord_status');
            $this->db->select('ord_created');
            $this->db->select('ord_updated');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('ord_id');
            $this->db->select('ord_code');
            $this->db->select('ord_fordate');
            $this->db->select('ord_date');
            $this->db->select('ord_isdelivery');
            $this->db->select('ord_delivaddress');   
            $this->db->select('ord_delivcity');
            $this->db->select('ord_delivprovince');
            $this->db->select('ord_delivzip');
            $this->db->select('ord_subtotal');
            $this->db->select('ord_total');
            $this->db->select('ord_discount');
            $this->db->select('ord_type');
            $this->db->select('ord_status');
            $this->db->select('ord_created');
            $this->db->select('ord_updated');

            $this->db->select('dsc_name');
            $this->db->select('dsc_value');
            $this->db->select('dsc_unit');

        }
        $this->db->from($this->table_name);
        $this->db->join('discount','dsc_id = ord_discount','left');
    }

    public function insert(
                            $ord_code = FALSE,
                            $ord_fordate = FALSE,
                            $ord_date = FALSE,
                            $ord_isdelivery = FALSE,
                            $ord_delivaddress = FALSE,
                            $ord_delivcity = FALSE,
                            $ord_delivprovince = FALSE,
                            $ord_delivzip = FALSE,
                            $ord_subtotal = FALSE,
                            $ord_total = FALSE,
                            $ord_discount = FALSE,
                            $ord_type = FALSE,
                            $ord_status = FALSE,
                            $ord_created = FALSE,
                            $ord_updated = FALSE
                        ){
        $data = array();
        if($ord_code !== FALSE) $data['ord_code'] = trim($ord_code);
        if($ord_fordate !== FALSE) $data['ord_fordate'] = trim($ord_fordate);
        if($ord_date !== FALSE) $data['ord_date'] = trim($ord_date);
        if($ord_isdelivery !== FALSE) $data['ord_isdelivery'] = $ord_isdelivery;
        if($ord_delivaddress !== FALSE) $data['ord_delivaddress'] = trim($ord_delivaddress);
        if($ord_delivcity !== FALSE) $data['ord_delivcity'] = trim($ord_delivcity);
        if($ord_delivprovince !== FALSE) $data['ord_delivprovince'] = trim($ord_delivprovince);
        if($ord_delivzip !== FALSE) $data['ord_delivzip'] = trim($ord_delivzip);
        if($ord_subtotal !== FALSE) $data['ord_subtotal'] = $ord_subtotal;
        if($ord_total !== FALSE) $data['ord_total'] = $ord_total;
        if($ord_discount !== FALSE) $data['ord_discount'] = $ord_discount;
        if($ord_type !== FALSE) $data['ord_type'] = $ord_type;
        if($ord_status !== FALSE) $data['ord_status'] = $ord_status;
        if($ord_created !== FALSE) $data['ord_created'] = trim($ord_created);
        if($ord_updated !== FALSE) $data['ord_updated'] = trim($ord_updated);
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $ord_id     = FALSE,
                            $ord_code = FALSE,
                            $ord_fordate = FALSE,
                            $ord_date = FALSE,
                            $ord_isdelivery = FALSE,
                            $ord_delivaddress = FALSE,
                            $ord_delivcity = FALSE,
                            $ord_delivprovince = FALSE,
                            $ord_delivzip = FALSE,
                            $ord_subtotal = FALSE,
                            $ord_total = FALSE,
                            $ord_discount = FALSE,
                            $ord_type = FALSE,
                            $ord_status = FALSE,
                            $ord_created = FALSE,
                            $ord_updated = FALSE){
        $data = array();
        if($ord_code !== FALSE) $data['ord_code'] = trim($ord_code);
        if($ord_fordate !== FALSE) $data['ord_fordate'] = trim($ord_fordate);
        if($ord_date !== FALSE) $data['ord_date'] = trim($ord_date);
        if($ord_isdelivery !== FALSE) $data['ord_isdelivery'] = $ord_isdelivery;
        if($ord_delivaddress !== FALSE) $data['ord_delivaddress'] = trim($ord_delivaddress);
        if($ord_delivcity !== FALSE) $data['ord_delivcity'] = trim($ord_delivcity);
        if($ord_delivprovince !== FALSE) $data['ord_delivprovince'] = trim($ord_delivprovince);
        if($ord_delivzip !== FALSE) $data['ord_delivzip'] = trim($ord_delivzip);
        if($ord_subtotal !== FALSE) $data['ord_subtotal'] = $ord_subtotal;
        if($ord_total !== FALSE) $data['ord_total'] = $ord_total;
        if($ord_discount !== FALSE) $data['ord_discount'] = $ord_discount;
        if($ord_type !== FALSE) $data['ord_type'] = $ord_type;
        if($ord_status !== FALSE) $data['ord_status'] = $ord_status;
        if($ord_created !== FALSE) $data['ord_created'] = trim($ord_created);
        if($ord_updated !== FALSE) $data['ord_updated'] = trim($ord_updated);
        return $this->db->update($this->table_name,$data,'ord_id = '.$ord_id);
    }



    


}