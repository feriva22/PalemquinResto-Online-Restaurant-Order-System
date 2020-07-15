<?php
    class CompanyInfo extends CI_Model {


        function getCompanyInfo(){
            //get from table informasi_perusahaan
            $query = $this->db->get('informasi_perusahaan',1);
            return $query->result();
        }
    }