<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_departments
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_departments
 * @model Settings
 **/

class  Pm_departments extends \Model { 
	public $_table ='pm_departments';  
 	 public $_fields = [
	 'pm_department_id' =>  ['int',11,'PRI'],
	 'title' =>  ['varchar',225],
	 'time' =>  ['datetime'],
	 'description' =>  ['longtext'],
	 ];
 
 
	public function rules() {
        return [
            
            'all' => [
             'title' => ['required'],
             'description' => ['required'],
			],

		];
 
 
} 
 
 
	public function fields() {
        return [
	 'title' =>'title', 
	 'time' =>'time', 
	 'description' =>'description',
		];
    }
} 
 