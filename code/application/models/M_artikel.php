<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_artikel extends MY_Model {
    protected $pk_col = 'art_id';
    protected $table_name = 'articles';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('art_id');
            $this->db->select('stf_name AS art_staff');
            $this->db->select('art_name');
            $this->db->select('art_slug');
            $this->db->select('art_content');
            $this->db->select('art_status');
            $this->db->select('art_created');
            $this->db->select('art_updated');

        } 
        else{
            //for detail get like sensitive information
            $this->db->select('art_id');
            $this->db->select('stf_name AS art_staff');
            $this->db->select('art_name');
            $this->db->select('art_slug');
            $this->db->select('art_content');
            $this->db->select('art_status');
            $this->db->select('art_created');
            $this->db->select('art_updated');
        }
        $this->db->from($this->table_name);
        $this->db->join('staff','stf_id = art_staff');
    }

    public function insert( 
                            $art_staff = FALSE,
                            $art_name = FALSE,
                            $art_slug = FALSE,
                            $art_content = FALSE,
                            $art_status = FALSE,
                            $art_created = FALSE,
                            $art_updated = FALSE
                                    ){
        $data = array();
        if($art_staff !== FALSE) $data['art_staff'] = $art_staff;
        if($art_name !== FALSE) $data['art_name'] = trim($art_name);
        if($art_slug !== FALSE) $data['art_slug'] = trim($art_slug);
        if($art_content !== FALSE) $data['art_content'] = $art_content;
        if($art_status !== FALSE) $data['art_status'] = $art_status;
        if($art_created !== FALSE) $data['art_created'] = $art_created;
        if($art_updated !== FALSE) $data['art_updated'] = $art_updated;

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $art_id = FALSE,
                            $art_staff = FALSE,
                            $art_name = FALSE,
                            $art_slug = FALSE,
                            $art_content = FALSE,
                            $art_status = FALSE,
                            $art_created = FALSE,
                            $art_updated = FALSE){
        $data = array();
        if($art_staff !== FALSE) $data['art_staff'] = $art_staff;
        if($art_name !== FALSE) $data['art_name'] = trim($art_name);
        if($art_slug !== FALSE) $data['art_slug'] = trim($art_slug);
        if($art_content !== FALSE) $data['art_content'] = $art_content;
        if($art_status !== FALSE) $data['art_status'] = $art_status;
        if($art_created !== FALSE) $data['art_created'] = $art_created;
        if($art_updated !== FALSE) $data['art_updated'] = $art_updated;
        
        return $this->db->update($this->table_name,$data,'art_id = '.$art_id);
    }



    


}