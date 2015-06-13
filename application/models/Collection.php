<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Фабрика коллекций
*
* @author    DJZT
*/
abstract class Collection {
 
    /**
    * Создаёт коллекцию заданного типа.
    *
    * @param string $type  Тип коллекции
    * @return mixed
    */
    public static function create($type){
        $class = $type . 'Collection';
        include_once APPPATH.'models/collections/'.$class.'.php';
        $obj = new $class($type);
        return $obj;
    }
}