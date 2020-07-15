<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends MY_Model {
    protected $pk_col = 'mnu_id';
    protected $table_name = 'menu';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('mnu_id');
            $this->db->select('mnu_name');
            $this->db->select('mnu_desc');
            $this->db->select('mnc_name AS mnu_category');
            $this->db->select('mnu_price');
            $this->db->select('mnu_photo');
            $this->db->select('mnu_minorder');
            $this->db->select('mnu_variant_parent');
            $this->db->select('mnu_status');
            $this->db->select('mnu_created');
            $this->db->select('mnu_updated');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('mnu_id');
            $this->db->select('mnu_name');
            $this->db->select('mnu_desc');
            $this->db->select('mnu_category');
            $this->db->select('mnu_price');
            $this->db->select('mnu_photo');
            $this->db->select('mnu_minorder');
            $this->db->select('mnu_variant_parent');
            $this->db->select('mnu_status');
            $this->db->select('mnu_created');
            $this->db->select('mnu_updated');
        }
        $this->db->from($this->table_name);
        $this->db->join('menu_category','mnu_category = mnc_id');
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
                            $mnu_name = FALSE,
                            $mnu_desc = FALSE,
                            $mnu_category = FALSE,
                            $mnu_price = FALSE,
                            $mnu_photo = FALSE,
                            $mnu_minorder = FALSE,
                            $mnu_variant_parent = FALSE,
                            $mnu_status = FALSE,
                            $mnu_created = FALSE,
                            $mnu_updated = FALSE
                            ){
        $data = array();
        if($mnu_name !== FALSE) $data['mnu_name'] = trim($mnu_name);
        if($mnu_desc !== FALSE) $data['mnu_desc'] = trim($mnu_desc);
        if($mnu_category !== FALSE) $data['mnu_category'] = intval($mnu_category);
        if($mnu_price !== FALSE) $data['mnu_price'] = intval($mnu_price);
        if($mnu_photo !== FALSE) $data['mnu_photo'] = trim($mnu_photo);
        if($mnu_minorder !== FALSE) $data['mnu_minorder'] = trim($mnu_minorder);
        if($mnu_variant_parent !== FALSE) $data['mnu_variant_parent'] = intval($mnu_variant_parent);
        if($mnu_status !== FALSE) $data['mnu_status'] = intval($mnu_status);
        if($mnu_created !== FALSE) $data['mnu_created'] = trim($mnu_created);
        if($mnu_updated !== FALSE) $data['mnu_updated'] = trim($mnu_updated);
        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $mnu_id = FALSE,
                            $mnu_name = FALSE,
                            $mnu_desc = FALSE,
                            $mnu_category = FALSE,
                            $mnu_price = FALSE,
                            $mnu_photo = FALSE,
                            $mnu_minorder = FALSE,
                            $mnu_variant_parent = FALSE,
                            $mnu_status = FALSE,
                            $mnu_created = FALSE,
                            $mnu_updated = FALSE
    ){
        $data = array();
        if($mnu_name !== FALSE) $data['mnu_name'] = trim($mnu_name);
        if($mnu_desc !== FALSE) $data['mnu_desc'] = trim($mnu_desc);
        if($mnu_category !== FALSE) $data['mnu_category'] = intval($mnu_category);
        if($mnu_price !== FALSE) $data['mnu_price'] = intval($mnu_price);
        if($mnu_photo !== FALSE) $data['mnu_photo'] = trim($mnu_photo);
        if($mnu_minorder !== FALSE) $data['mnu_minorder'] = trim($mnu_minorder);
        if($mnu_variant_parent !== FALSE) $data['mnu_variant_parent'] = intval($mnu_variant_parent);
        if($mnu_status !== FALSE) $data['mnu_status'] = intval($mnu_status);
        if($mnu_created !== FALSE) $data['mnu_created'] = trim($mnu_created);
        if($mnu_updated !== FALSE) $data['mnu_updated'] = trim($mnu_updated);
        
        return $this->db->update($this->table_name,$data,'mnu_id = '.$mnu_id);
    }



    


}