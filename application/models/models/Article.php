<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends DbModel {

	public $id 			= 0;
	public $title 		= "";
	public $text 		= "";
	public $date 		= "";
	public $id_user		= 0;

	private $_author 	= null;

	protected $table 	= 'article';


	public function get_author(){
		if (is_null($this->_author)) {
			$User = Model::create('User');
			$User->fetch(array('id' => $this->id_user));
			$this->_author = $User;
		}
		return $this->_author;
	}

	public function get_date(){
		
	}

}

/* End of file Article.php */
/* Location: ./application/models/models/Article.php */