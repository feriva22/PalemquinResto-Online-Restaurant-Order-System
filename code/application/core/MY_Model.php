<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{

    protected $pk_col = '';
    protected $table_name = '';

	protected $default_select = TRUE;

    public function __construct()
    { parent::__construct(); }
    
    public function custom_query($query){
		$query_result = $this->db->query($query);
		return $query_result->result();
	}
	
	public function get_last_id(){
		$result = $this->get("",$this->pk_col.' desc',1);
		if($result !== NULL){
			return $result->{$this->pk_col};
		}else{
			return 1; //default if table empty return 1
		}
	}
    
    public function count_total($where="", $escape=NULL){
		$this->select();
		if($where !== "") $this->db->where($where, NULL, $escape);
		//return number of data
		return $this->db->count_all_results();
	}
	
	public function set_select_mode($mode){
		$this->default_select = !($mode === 'detail');
	}
    
    public function get($where="", $order="", $limit=NULL, $offset=NULL, $escape=NULL){
		$this->select();
		if($order !== "") $this->db->order_by($order, '', $escape);

		if(!is_exist($limit) && !is_exist($offset)) $this->db->limit($limit, $offset);
		else if(!is_exist($limit)) $this->db->limit($limit);

		if($where !== "") $this->db->where($where, NULL, $escape);

		//get data and return it
		$query = $this->db->get();
		$result = $query->result();

		if($limit === 1)
			return count($result) == 0 ? NULL : $result[0];

		return $result;
	}
	
	public function get_datatable($where=NULL,$order=NULL){
		
        $result = $this->get($where,$order);
        
        echo json_encode(array(
            'data' => $result,
            'draw' => 0,
            'recordsTotal' => count($result)
        ));
        exit;
    }
    
    public function get_by_multiple_column($column_definition, $num_return=1, $order_by='', $escape=NULL){
		//check parameter definition
		if(!is_array($column_definition)) return array();

		if(count($column_definition) > 0)
			$this->db->where($column_definition, NULL, $escape);
		$this->select();
		if(!is_exist($order_by)) $this->db->order_by($order_by, '', $escape);
		if($num_return > 0) $this->db->limit($num_return);
		$query = $this->db->get();
		$result = $query->result();

		if($num_return === 1){
			return count($result) == 0 ? NULL : $result[0];
		}
		return $result;
    }
    
    public function get_by_column($data, $column='', $num_return=1, $order_by='', $escape=NULL){
		if($column === '')
			$column = $this->pk_col;
		//if no data supplied, return null
		if(empty($data)) return NULL;
		//get data call other method
		return $this->get_by_multiple_column(array($column => $data), $num_return, $order_by, $escape);
    }
    
    public function update_multiple_column($column_data, $id_val, $id_col='', $is_custom_where = FALSE){
		if(is_exist($id_col)) $id_col = $this->pk_col;
		return $this->db->update($this->table_name, $column_data, $is_custom_where ? $id_val : "$id_col = '$id_val'");
    }
    
    public function update_single_column($change_column, $change_value, $id_val, $id_col='', $is_custom_where = FALSE){
		return $this->update_multiple_column(array($change_column => $change_value), $id_val, $id_col, $is_custom_where);
    }
}