<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_transaksi extends MY_Model {
    protected $pk_col = 'trs_id';
    protected $table_name = 'transaction';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('trs_id');
            $this->db->select('trs_code');
            $this->db->select('trs_date');
            $this->db->select('trs_invoicecode');
            $this->db->select('trs_paygateway');
            $this->db->select('trs_total');
            $this->db->select('trs_name');
            $this->db->select('trs_email');
            $this->db->select('trs_note');
            $this->db->select('trs_photo');
            $this->db->select('trs_status');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('trs_id');
            $this->db->select('trs_code');
            $this->db->select('trs_date');
            $this->db->select('trs_invoicecode');
            $this->db->select('trs_paygateway');
            $this->db->select('trs_total');
            $this->db->select('trs_name');
            $this->db->select('trs_email');
            $this->db->select('trs_note');
            $this->db->select('trs_photo');
            $this->db->select('trs_status');
        }
        $this->db->from($this->table_name);
    }

    public function insert( 
                            $trs_code = FALSE,
                            $trs_date = FALSE,
                            $trs_invoicecode = FALSE,
                            $trs_paygateway = FALSE,
                            $trs_total = FALSE,
                            $trs_name = FALSE,
                            $trs_email = FALSE,
                            $trs_note = FALSE,
                            $trs_photo = FALSE,
                            $trs_status = FALSE
                            ){
        $data = array();
        if($trs_code !== FALSE) $data['trs_code'] = trim($trs_code);
        if($trs_date !== FALSE) $data['trs_date'] = trim($trs_date);
        if($trs_invoicecode !== FALSE) $data['trs_invoicecode'] = trim($trs_invoicecode);
        if($trs_paygateway !== FALSE) $data['trs_paygateway'] = trim($trs_paygateway);
        if($trs_total !== FALSE) $data['trs_total'] = trim($trs_total);
        if($trs_name !== FALSE) $data['trs_name'] = trim($trs_name);
        if($trs_email !== FALSE) $data['trs_email'] = trim($trs_email);
        if($trs_note !== FALSE) $data['trs_note'] = trim($trs_note);
        if($trs_photo !== FALSE) $data['trs_photo'] = trim($trs_photo);
        if($trs_status !== FALSE) $data['trs_status'] = trim($trs_status);
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $trs_id = FALSE,
                            $trs_code = FALSE,
                            $trs_date = FALSE,
                            $trs_invoicecode = FALSE,
                            $trs_paygateway = FALSE,
                            $trs_total = FALSE,
                            $trs_name = FALSE,
                            $trs_email = FALSE,
                            $trs_note = FALSE,
                            $trs_photo = FALSE,
                            $trs_status = FALSE){
        $data = array();
        if($trs_code !== FALSE) $data['trs_code'] = trim($trs_code);
        if($trs_date !== FALSE) $data['trs_date'] = trim($trs_date);
        if($trs_invoicecode !== FALSE) $data['trs_invoicecode'] = trim($trs_invoicecode);
        if($trs_paygateway !== FALSE) $data['trs_paygateway'] = trim($trs_paygateway);
        if($trs_total !== FALSE) $data['trs_total'] = trim($trs_total);
        if($trs_name !== FALSE) $data['trs_name'] = trim($trs_name);
        if($trs_email !== FALSE) $data['trs_email'] = trim($trs_email);
        if($trs_note !== FALSE) $data['trs_note'] = trim($trs_note);
        if($trs_photo !== FALSE) $data['trs_photo'] = trim($trs_photo);
        if($trs_status !== FALSE) $data['trs_status'] = trim($trs_status);

        return $this->db->update($this->table_name,$data,'trs_id = '.$trs_id);
    }



    


}