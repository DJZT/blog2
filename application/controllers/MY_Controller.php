<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'models/Model.php';
include_once APPPATH.'models/Collection.php';

class MY_Controller extends CI_Controller {

	public $data = array();

	function __construct(){

		parent::__construct(); // Наследование родительского конструктора

		// Определение текущего пользователя
		// $this->load->library('User', array('id' => $this->session->userdata('id_user')));
		// if ($this->user->logged()) {
		// 	$this->user->last_activity = date("Y-m-d H:i:s");
		// 	$this->user->save();
		// 	$this->data['user'] = $this->user;
		// }
		// $this->data['load_menu'] = 'default';

		$User = Model::create('User');
		// print_r($user);
		if ($User->fetch(array('id' => $this->session->userdata('id_user'))) && $User->is_logged()) {
			$User->set('last_activity', date("Y-m-d H:i:s"));
			$User->save();
		}
		$this->data['User'] = $User;



	}


}