<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Model {

	public static function create($type){
        $class = $type;
        include_once APPPATH.'models/models/'.$class.'.php';
        $obj = new $class();
        return $obj;
    }

}