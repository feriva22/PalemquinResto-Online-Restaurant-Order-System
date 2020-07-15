<?php
    class MCustomer extends CI_Model {

        public function getCustomer($filter = null){
            return $this->db->get_where('customer',$filter);

        }

        public function addCustomer($data){
            $this->db->insert('customer',$data);
            return $this->db->insert_id();
        }

        public function updateCustomer($id,$data){
            $this->db->where('cst_id',$id);
            $this->db->update('customer',$data);
        }

        public function updValidEmail($id,$data){
            $this->db->where('iduser_pelanggan',(int)$id);
            $this->db->update('user_pelanggan',$data);
        }

        public function listInvoice($filter = null){
            $this->db->select('inv_code,ord_code AS inv_order,inv_date,inv_duedate,inv_total,inv_status');
            $this->db->from('invoice');
            $this->db->join('order','ord_id = inv_order');
            if(isset($filter)) $this->db->where($filter);
            $query = $this->db->get();
            $result = $query->result();

            echo json_encode(array(
                'data' => $result,
                'draw' => 0,
                'recordsTotal' => count($result)
            ));
            exit;
        }


        public function listTransaction($filter = null){
            $this->db->select('trs_code,trs_invoicecode ,trs_date,trs_paygateway,trs_total,trs_status');
            $this->db->from('transaction');
            if(isset($filter)) $this->db->where($filter);
            $query = $this->db->get();
            $result = $query->result();

            echo json_encode(array(
                'data' => $result,
                'draw' => 0,
                'recordsTotal' => count($result)
            ));
            exit;
        }

        public function get_lasttransaction_id(){
            $this->db->order_by('trs_id','desc');
            $result = $this->db->get("transaction",0,1)->row();
            if($result !== NULL){
                return $result->trs_id;
            }else{
                return 1; //default if table empty return 1
            }
        }

        public function addTransaction($data){
             $this->db->insert('transaction',$data);
             return $this->db->insert_id();
        }
    }