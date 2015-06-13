<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'models/DbModel.php';

class User extends DbModel {

	public 	$id 				= 0;
	public 	$first_name 		= '';
	public 	$last_name 			= '';
	public  $email 				= '';
	public 	$password 			= '';
	public  $id_role			= 0;
	public  $last_activity 		= "";
	protected $table 			= "user";

	private	$__group 		= null;
	private	$__role 		= null;
	private $__tests 		= null;

	protected   $first_last_name = "";

	public function login(){
		$CI =& get_instance();
		$authdata = array('logged_in' => true, 'id_user' => $this->id);
        $CI->session->set_userdata($authdata);
	}

	public function register($params = array()){
		if (!$params) {
			$this->set('password', md5($this->password));
			$this->set('last_activity', date("Y-m-d H:i:s"));
			$this->save();
		}else{
			$this->set($params);
			$this->set('password', md5($this->password));
			$this->set('last_activity', date("Y-m-d H:i:s"));
			$this->save();
		}
	}

	public function out(){
		$CI =& get_instance();
        $CI->session->sess_destroy();
	}

	public function get_assigments(){
		$Assigments = Collection::create("Assigment");
		$Assigments->fetch(array('id_user' => $this->id));
	}

	public function get_avatar(){
		if (file_exists($this->avatar)) {
			return base_url().$this->avatar;
		}else{
			return base_url()."images/avatars/default.jpg";
		}	
	}

	function is_online(){
		$add15 = new DateTime($this->last_activity);
		$add15->add(new DateInterval('PT15M'));

		if ($add15 > new DateTime(date("Y-m-d H:i:s"))) {
			return true;
		}
		return false;
	}

	function time_last_activity(){
		if($this->last_activity == ""){
			return "";
		}else{
			$curent_date = strtotime(date("Y-m-d H:i:s"));
			$last_activity = strtotime($this->last_activity);

			$time = $curent_date - $last_activity;

			if ($time < 60) {
				return $time." сек.";
			}elseif($time/60 < 60){
				return round($time/60)." мин.";
			}elseif($time/60/24 < 24){
				return round($time/60/24)." ч.";
			}elseif($time/60/24/30 < 30){
				return round($time/60/24/30)." д.";
			}elseif($time/60/24/30 < 12){
				return round($time/60/24/30)." мес.";
			}else{
				return round($time/60/24/30/12)." лет.";
			}

		}
	}

	
	function is_logged(){
		return ($this->id == 0)? false: true;
	}

	public function get_role(){
		if (is_null($this->__role)) {
			$Role = Model::create("Role");
			$Role->fetch(array('id' => $this->id_role));
			$this->__role = $Role;
		}
		return $this->__role;
	}

	public function encrypting_password(){
		$this->set('password', md5($this->password));
	}
}

/* End of file User.php */
/* Location: ./application/models/User.php */