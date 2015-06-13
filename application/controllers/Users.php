<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once "MY_Controller.php";

class Users extends MY_Controller {

	public function login(){
		$this->data['title'] = 'Авторизация';
		if ($this->data['User']->is_logged()) {
			redirect(base_url());
		}elseif($this->input->post('password')){
			// Logged
			if ($this->data['User']->fetch(array('email' => $this->input->post('email'), 'password' => md5($this->input->post('password'))))) {
				$this->data['User']->login();
                redirect(base_url());
			}else{
				$this->data['errors'][] 	= 'User not found';
				$this->data['load_view'] 	= 'users/login';
				$this->load->view('page', $this->data);
			}

		}else{
			$this->data['load_view'] = 'users/login';
			$this->load->view('page', $this->data);
		}
	}

	public function out(){
		if ($this->data['User']->is_logged()) {
			$this->data['User']->out();
		}
		redirect(base_url());
	}


	public function register(){
		$this->data['title'] = 'Регистрация';
		if ($this->data['User']->is_logged()) {
			redirect(base_url('users/profile'));
		}

		$this->load->library('Form_validation');

		if ($this->input->post('register')){
			// set config validation
			$this->form_validation->set_rules('email', 			'E-Mail', 				'trim|required|valid_email|is_unique[user.email]');
			$this->form_validation->set_rules('first_name', 	'Last name', 			'trim');
			$this->form_validation->set_rules('last_name', 		'First name', 			'trim');
			$this->form_validation->set_rules('password', 		'Password', 			'trim|required|min_length[6]|max_length[16]');
			$this->form_validation->set_rules('conf_password', 	'Confirmation password','trim|required|matches[password]');

			$this->form_validation->set_message('is_unique', 'This e-mail registered');

			if ($this->form_validation->run()) {
				// Register user

				$this->data['User']->set('email', 			$this->input->post('email'));
				$this->data['User']->set('first_name', 		$this->input->post('first_name'));
				$this->data['User']->set('last_name', 		$this->input->post('last_name'));
				$this->data['User']->set('password', 		md5($this->input->post('password')));
				$this->data['User']->set('last_activity',	date("Y-m-d H:i:s"));
				$this->data['User']->set('id_role', 2);
				$this->data['User']->save();

				// Login
				$this->data['User']->login();
				redirect(base_url());
			}

		}else{
			$this->data['load_view'] = 'users/register';
		}
		
		$this->load->view('page', $this->data);
	}

	protected function valid_fio($str){
		if ($str == preg_match('^А-Яа-я0-9\s/', $str)){
			$this->form_validation->set_message('username_check', 'Поле %s должно содержать симолы "А-Я а-я 0-9 "');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	protected function valid_pass($str){
		if ($str == preg_match('^A-Za-z0-9\s/', $str)){
			$this->form_validation->set_message('username_check', 'Поле %s должно содержать симолы "A-Z a-z 0-9 "');
			return FALSE;
		}else{
			return TRUE;
		}
	}

}
?>