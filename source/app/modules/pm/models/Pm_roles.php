<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_roles
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_roles
 * @model Settings
 **/

class  Pm_roles extends \Model { 
	public $_table ='pm_roles';  
 	 public $_fields = [
	 'pm_role_id' =>  ['int',11,'PRI'],
	 'title' =>  ['varchar',100],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'title' => ['required'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'title' =>'title',
		];
    }
} 
 