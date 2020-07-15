<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_pemesananinvoice extends MY_Model {
    protected $pk_col = 'inv_id';
    protected $table_name = 'invoice';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('inv_id');
            $this->db->select('inv_code');
            $this->db->select('ord_code as inv_order');
            $this->db->select('inv_customer');
            $this->db->select('inv_date');
            $this->db->select('inv_duedate');
            $this->db->select('inv_paygateway');
            $this->db->select('inv_isdp');
            $this->db->select('inv_dp');
            $this->db->select('inv_dpvalue');
            $this->db->select('inv_total');
            $this->db->select('inv_status');
            $this->db->select('inv_created');
            $this->db->select('inv_updated'); 
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('inv_id');
            $this->db->select('inv_code');
            $this->db->select('inv_order');
            $this->db->select('inv_customer');
            $this->db->select('inv_date');
            $this->db->select('inv_duedate');
            $this->db->select('inv_paygateway');
            $this->db->select('inv_isdp');
            $this->db->select('inv_dp');
            $this->db->select('inv_dpvalue');
            $this->db->select('inv_total');
            $this->db->select('inv_status');
            $this->db->select('inv_created');
            $this->db->select('inv_updated');
        }
        $this->db->from($this->table_name);
        $this->db->join('order','inv_order = ord_id');
    }

    public function search($column_definition, $offset = 0, $limit = 30,$escape = NULL){
        $this->select();
        
        if($column_definition == ""){
            return NULL;
        }
        $this->db->where($column_definition, NULL, $escape);
    
        
        $this->db->limit($limit,$offset);

        $query = $this->db->get();
        $result = $query->result();

        if($limit === 1){
			return count($result) == 0 ? NULL : $result[0];
		}
		return $result;
    }

    public function insert(
                            $inv_code = FALSE,
                            $inv_order = FALSE,
                            $inv_customer = FALSE,
                            $inv_date = FALSE,
                            $inv_duedate = FALSE,
                            $inv_paygateway = FALSE,
                            $inv_isdp = FALSE,
                            $inv_dp = FALSE,
                            $inv_dpvalue = FALSE,
                            $inv_total = FALSE,
                            $inv_status = FALSE,
                            $inv_created = FALSE,
                            $inv_updated = FALSE
                            ){
        $data = array();
        if($inv_code !== FALSE) $data['inv_code'] = trim($inv_code);
        if($inv_order !== FALSE) $data['inv_order'] = $inv_order;
        if($inv_customer !== FALSE) $data['inv_customer'] = $inv_customer;
        if($inv_date !== FALSE) $data['inv_date'] = trim($inv_date);
        if($inv_duedate !== FALSE) $data['inv_duedate'] = trim($inv_duedate);
        if($inv_paygateway !== FALSE) $data['inv_paygateway'] = $inv_paygateway;
        if($inv_isdp !== FALSE) $data['inv_isdp'] = $inv_isdp;
        if($inv_dp !== FALSE) $data['inv_dp'] = $inv_dp;
        if($inv_dpvalue !== FALSE) $data['inv_dpvalue'] = $inv_dpvalue;
        if($inv_total !== FALSE) $data['inv_total'] = $inv_total;
        if($inv_status !== FALSE) $data['inv_status'] = $inv_status;
        if($inv_created !== FALSE) $data['inv_created'] = trim($inv_created);
        if($inv_updated !== FALSE) $data['inv_updated'] = trim($inv_updated);
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $inv_id =FALSE,
                            $inv_code = FALSE,
                            $inv_order = FALSE,
                            $inv_customer = FALSE,
                            $inv_date = FALSE,
                            $inv_duedate = FALSE,
                            $inv_paygateway = FALSE,
                            $inv_isdp = FALSE,
                            $inv_dp = FALSE,
                            $inv_dpvalue = FALSE,
                            $inv_total = FALSE,
                            $inv_status = FALSE,
                            $inv_created = FALSE,
                            $inv_updated = FALSE){
        $data = array();
        if($inv_code !== FALSE) $data['inv_code'] = trim($inv_code);
        if($inv_order !== FALSE) $data['inv_order'] = $inv_order;
        if($inv_customer !== FALSE) $data['inv_customer'] = $inv_customer;
        if($inv_date !== FALSE) $data['inv_date'] = trim($inv_date);
        if($inv_duedate !== FALSE) $data['inv_duedate'] = trim($inv_duedate);
        if($inv_paygateway !== FALSE) $data['inv_paygateway'] = $inv_paygateway;
        if($inv_isdp !== FALSE) $data['inv_isdp'] = $inv_isdp;
        if($inv_dp !== FALSE) $data['inv_dp'] = $inv_dp;
        if($inv_dpvalue !== FALSE) $data['inv_dpvalue'] = $inv_dpvalue;
        if($inv_total !== FALSE) $data['inv_total'] = $inv_total;
        if($inv_status !== FALSE) $data['inv_status'] = $inv_status;
        if($inv_created !== FALSE) $data['inv_created'] = trim($inv_created);
        if($inv_updated !== FALSE) $data['inv_updated'] = trim($inv_updated);
        
        return $this->db->update($this->table_name,$data,'inv_id = '.$inv_id);
    }



    


}