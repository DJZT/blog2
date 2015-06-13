<?php defined('BASEPATH') OR exit('No direct script access allowed');

include_once "MY_Controller.php";

class Articles extends MY_Controller {


	public function index($page = 1){
		$this->all();
	}

	public function all($page = 1){
		// call delete action
		$this->remove();

		$Articles = Collection::create('Article');
		$Articles->all();
		$this->data['title'] 		= "Articles";
		$this->data['Articles'] 	= $Articles;
		$this->data['load_view'] 	= 'articles/list';
		$this->load->view('page', $this->data);
	}

	public function item($id){
		$Article = Model::create('Article');
		$Article->fetch(array('id' => $id));
		if (!$Article->id) {
			$this->data['load_view'] = 'articles/not_found';
		}else{
			$this->data['Article'] = $Article;
			$this->data['load_view'] = 'articles/item';
		}
		$this->load->view('page', $this->data);
	}

	public function add(){
		if (!$this->is_access()) { return null;}
		if ($this->input->post('add')) {
			$this->data['title'] 		= "Added article";
			$this->data['load_view'] 	= 'articles/item';

			$Article = Model::create('Article');
			$Article->set('title', $this->input->post('title'));
			$Article->set('text', $this->input->post('text'));
			$Article->set('date', date('Y-m-d H:i:s'));
			$Article->set('id_user', $this->data['User']->id);
			$Article->save();

			$this->data['Article'] 	= $Article;
		}else{
			$this->data['title'] = "Add article";
			$this->data['load_view'] = 'articles/add';
		}

		$this->load->view('page', $this->data);
	}

	public function edit($id){
		if (!$this->is_access()) { return null;}
		$this->data['title'] = "Edit article";
		$Article = Model::create('Article');
		if (!$Article->fetch(array('id' => $id))) {
			$this->data['load_view'] = 'articles/not_found';
		}elseif($this->input->post('edit')) {
			$Article->set('title', $this->input->post('title'));
			$Article->set('text', $this->input->post('text'));
			$Article->set('date', date('Y-m-d H:i:s'));
			$Article->set('id_user', $this->data['User']->id);
			$Article->save();

			$this->data['success'][] = "Article successfully edited";
		}

		$this->data['Article'] 		= $Article;
		$this->data['load_view'] 	= 'articles/edit';

		$this->load->view('page', $this->data);
	}

	private function remove(){
		
		if ($this->input->get('delete') && $this->is_access()) {
			$Article = Model::create('Article');
			$Article->fetch(array('id' => $this->input->get('delete')));
			if ($Article->delete()) {
				$this->data['success'][] = "Article successfully removed";
			}else{
				$this->data['error'][] = "Article not found";
			}
		}
	}
	
	private function is_access(){
		if (!$this->data['User']->is_logged()) {
			$this->data['load_view'] = 'users/no_access';
			$this->load->view('page', $this->data);
			return false;
		}else{
			return true;
		}
	}


}

/* End of file Articles.php */
/* Location: ./application/controllers/Articles.php */