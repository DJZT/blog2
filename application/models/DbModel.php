<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class DbModel {

	private $__onchanged = false;

	public function __construct(){
		$this->__onchanged = true;
	}

	public function get_ids(){
		if (isset($this->__ids_field)) {
			foreach ($this->__ids_field as $key => $value) {
				$this->$key = $this->$value();
			}
		}
	}

	public function get_table(){
		return $this->table;
	}

	public function save(){
		$CI =& get_instance();
		if (isset($this->id) && $this->id != 0) {
			$CI->db->where('id', $this->id);
			$CI->db->update(strtolower(get_class($this)), $this);
			$this->__onchanged = false;
		}else{
			unset($this->id);
			$CI->db->insert(strtolower(get_class($this)), $this);
			$this->id 		= $CI->db->insert_id();
			if ($this->id) {
				$this->__onchanged = false;
			}
			return $this->id;
		}
	}

	public function set($key, $value = null){
		if (is_array($key)) {
			foreach ($key as $key_ar => $value_ar) {
				if (isset($this->$key_ar)) {
					$this->$key_ar = $value_ar;
				}
			}
			$this->__onchanged = true;
			return true;
		}elseif(is_string($key) && !is_null($value) && isset($this->$key)){
			$this->$key = $value;
			$this->__onchanged = true;
			return true;
		}
		return false;
	}

	public function get($field){
		//if (isset($this->field)) {
			return $this->$field;
		//}else{
		//	return null;
		//}
	}

	public function delete(){
		$CI =& get_instance();
		if ($this->id != 0) {
			$CI->db->where(array('id' => $this->id));
			$CI->db->delete(strtolower(get_class($this)));
			return true;
		}
		return false;
	}

	public function fetch($params = array()){
		$CI =& get_instance();
		if ($params) {
			// print_r($this->table);
			// print_r($params);
			$q = $CI->db->where($params)->from($this->table)->get();
			if ($q->num_rows() > 0) {
				$rez_array = $q->row_array();
				foreach ($rez_array as $key => $value) {
					if (isset($this->$key)) {
						$this->$key = $value;
					}
				}
				return true;
			}else{
				// echo "string";
				return false;
			}
		}
		// elseif ($this->id != 0) {
		// 	$q = $CI->db->where('id', $this->id)->from(strtolower(get_class($this)))->get();
		// 	if ($q->num_rows > 0) {
		// 		$rez_array = $q->row_array();
		// 		foreach ($rez_array as $key => $value) {
		// 			if (isset($this->$key)) {
		// 				$this->$key = $value;
		// 			}
		// 		}
		// 		return true;
		// 	}else{
		// 		return false;
		// 	}
		// }
		return false;
	}

	public function toJSON(){
		return json_encode($this);
	}

	function __toString(){
		return $this->id;
	}

}

/* End of file Base_model.php */
/* Location: ./application/models/Base_model.php */