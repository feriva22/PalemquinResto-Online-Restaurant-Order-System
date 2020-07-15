<?php 

    class ArticleModel extends CI_Model {

        public function get_total(){
            $result = $this->db->get_where('articles',array(
                                                'art_status ' => PUBLISH))->result();
            return $result !== NULL ? count($result) : 0;
        }

        public function get($where,$limit,$offset){
            $this->db->order_by('art_updated','desc');
            $this->db->join('staff','stf_id = art_staff');
            return $this->db->get_where('articles',$where,$limit,$offset)->result();
        }
    }

