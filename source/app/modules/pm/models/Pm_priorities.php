<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_priorities
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_priorities
 * @model Settings
 **/

class  Pm_priorities extends \Model { 
	public $_table ='pm_priorities';  
 	 public $_fields = [
	 'pm_priority_id' =>  ['int',11,'PRI'],
	 'name' =>  ['varchar',50],
	 'color' =>  ['varchar',50],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'name' => ['required'],
 	 'color' => ['required'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'name' =>'name', 
	 'color' =>'color',
		];
    }
} 
 