<?php
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Settings
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Settings
 * @model Settings
 **/
 
class  Settings extends Model { 
	public $_table ='settings';  
 	 public $_fields = [ 
	 'key' =>  ['varchar',100,'PRI'], 
	 'value' =>  ['varchar',255], 
	 'default_value' =>  ['varchar',255], 
	 'required' =>  ['tinyint',1], 
	];   
 
 
	public function rules() {
        return [ 	
        'all' => [ 
 	 'value' =>['required'], 
 	 'default_value' =>['required'], 
 	 'required' =>['required'], 
	 ], 	];   
 
 
} 
 
 
	public function fields() {
        return [ 
	 'value' =>'value', 
	 'default_value' =>'default value', 
	 'required' =>'required', 
	];
    }
} 
 