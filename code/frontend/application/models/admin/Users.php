<?php
    class Users extends CI_Model {
        
        function validate_admin($username,$password){
            /*
            $this->db->where('username',$username);
            $this->db->where('password',$password);
            $query = $this->db->get('user_admin',1);
            */
            $query = $this->db->query("SELECT * FROM user_admin WHERE username = '".$username."' AND password = '".$password."' LIMIT 1");
            return $query;
        }

        function get_adminUsers(){
            $this->db->select("user_admin.*,user_admin_role.nama_role as 'level_desc'");
            $this->db->from('user_admin');
            $this->db->join("user_admin_role",'user_admin.level = user_admin_role.iduser_admin_role');
            $this->db->order_by('level','ASC');
            $query = $this->db->get();
            return $query;

        }
    }