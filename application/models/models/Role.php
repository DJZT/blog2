<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'models/DbModel.php';

class Role extends DbModel {

	public $id 				= 0;
	public $title 			= "";
	public $access_panel 	= false;
	public $priority 		= 0;
	protected $table 		= "role";

}

/* End of file Group.php */
/* Location: ./application/models/models/Group.php */