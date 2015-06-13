<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 function __autoload($class_name){
	include_once APPPATH.'models/models/'.$class_name.'.php';
 }

include_once APPPATH.'models/BaseCollection.php';


abstract class DbCollection extends BaseCollection {

	/**
	 * Добавялет элементы в коллекцию
	 *
	 * @param object объект коллекции
	 * @param integer ID объекта в БД
	 * @return bool успех добавления
	 */
	public function add($el){
		if (is_numeric($el) && $el != 0) {
			
			// $this->load->model($this->class);
			$model = new $class();
			if ($model->fetch(array('id' => $el))) {
				$this->__collection[] = $model;
				return true;
			}
		}elseif(get_class($el) == $this->__type){
			$this->__collection[] = $el;
			return true;
		}
		return false;
	}


	/**
	 * Считывает из БД и добавляет элементы в коллекцию по переданным ID
	 *
	 * @param array IDs элементов
	 * @return bool успех добавления
	 */
	public function fetch($array_id = array()){
		$flag = false;
		if ($array_id) {
			$type = $this->__type;
			foreach ($array_id as $key => $value) {
				$model = new $type();
				if($model->fetch(array('id' => $value))){
					$this->__collection[] = $model;
					$flag = true;
				}
			}
		}
		return $flag;
	}

	/**
	 * Считывает из БД все элементы и добавляет их в коллекцию
	 *
	 * @param array параметры отсеивания в запросе
	 * @return mixed либо кол-во добавленных элементов, либо не удача
	 */
	public function all($params = array()){
		include_once APPPATH.'models/models/'.$this->__type.'.php';
		$CI =& get_instance();
		$type = $this->__type;
		$model = new $type();
		$table = $model->get_table();
		$q = $CI->db->where($params)->get($table);
		if ($q->num_rows()) {
			$count = 0;
			foreach ($q->result_array() as $key => $value) {
				$model = new $type();
				$model->set($value);
				$model->set('__onchanged', false);
				$this->__collection[] = $model;
				$count++;
			}
			return $count;
		}
		return false;
	}


	/**
	 * Сохранение всех элементов коллекции в БД
	 *
	 * @return bool успех сохраниния, если хотя бы одна была сохранена
	 */
	// public function save(){
	// 	if ($__collection) {
	// 		$flag = false;
	// 		foreach ($__collection as $key => $value) {
	// 			if ($value->__onchanged) {
	// 				$value->save();
	// 				$flag = true;
	// 			}
	// 		}
	// 		return $flag;
	// 	}
	// 	return false;
	// }

	/**
	 * Удаление элемента из коллекции по ключу
	 *
	 * @param integer ключ удаляемого элемента
	 * @return bool успех удаления
	 */
	public function remove($key){
		if ($key) {
			unset($this->__collection[$key]);
		}
	}

	/**
	 * Очистка коллекции
	 *
	 * @return void
	 */
	public function clear(){
		$this->__collection = array();
	}

	/**
	 * Сортировка коллекции по указанным полям
	 *
	 * @param array поля, по которым следует сортировать
	 * @return bool Успех сортировки
	 */
	public function sort(Array $fields){
		if (count($this->__collection) <= 1) {
			return false;
		}
		$field = "";
		while (count($fields != 0)) {
			$flag = true;

			if (count($fields) != 0) {
				$field = $fields[count($fields) - 1];
				unset($fields[count($fields) - 1]);
			}else{
				return false;
			}
			
			while ($flag) {
				$flag = false;
				foreach ($this->__collection as $key => $value) {
					if (preg_match('/^[A-Z]/', $field)) {
						$field2 = mb_strtolower($field);
						if (isset($this->__collection[$key+1]) && $this->__collection[$key]->$field2 < $this->__collection[$key+1]->$field2) {
							$temp 				= $this->__collection[$key];
							$this->__collection[$key] 	= $this->__collection[$key+1];
							$this->__collection[$key+1] 		= $temp;
							$flag = true;
						}
					}elseif(preg_match('/^[a-z]/', $field)){
						$field2 = mb_strtolower($field);
						if (isset($this->__collection[$key+1]) && $this->__collection[$key]->$field2 > $this->__collection[$key+1]->$field2) {
							$temp 					= $this->__collection[$key];
							$this->__collection[$key] 		= $this->__collection[$key+1];
							$this->__collection[$key+1] 	= $temp;
							$flag = true;
						}
					}	
				}
			}
		}

		return true;
	}

	public function sortRandom(){
		shuffle($this->__collection);
		return $this;
	}

	public function rand($count){
		$ids = array_rand($this->__collection, $count);
		foreach ($ids as $key => $value) {
			foreach ($this as $key2 => $value2) {
				if ($key2 != $value) {
					$this->remove($key);
				}
			}
		}
		
	}

	public function filter($filters = array()){
		
		foreach ($filters as $keyFilter => $filter) {
			foreach ($this->__collection as $key => $value) {
				if(is_numeric($filter) && $value->$keyFilter != $filter){
					
					unset($this->__collection[$key]);
				}elseif($filter && is_string($filter) && !is_numeric(stripos($value->get($keyFilter),$filter))){
					
					unset($this->__collection[$key]);
				}
				
			}
		}
	}

	/**
	 * Поиск элемента в коллекции по указанным параметрам
	 *
	 * @param array параметры фильтрации при поиске
	 * @return Collection коллекция найденных элементов
	 */
	// public function find($params = array()){
	// 	$collection = array();
	// 	if ($params) {
	// 		foreach ($this->data as $key => $value) {
	// 			$count_params = 0;
	// 			foreach ($params as $key2 => $value2) {
	// 				if (isset($value->$key2) && $value->$key2 == $value2) {
	// 					$count_params += 1;
	// 				}
	// 			}
	// 			if ($count_params == count($params)) {
	// 				$collection[] = $this->data[$key];
	// 			}
	// 		}
	// 	}
	// 	if ($collection) {
	// 		$find_collection = "Find_".$this->class.'s';
	// 		$this->load->model($this->class.'s', $find_collection);
	// 		foreach ($collection as $key => $value) {
	// 			$this->$find_collection->add($value);
	// 		}
			
	// 		return $this->$find_collection;
	// 	}
	// 	return false;
	// }

	function __toString(){
		return json_encode($this->__collection);
	}

	function get_ids(){
		foreach ($this->__collection as $key => $value) {
			$value->get_ids();
		}
	}

}