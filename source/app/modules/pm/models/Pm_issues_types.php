<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_issues_types
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_issues_types
 * @model Settings
 **/

class  Pm_issues_types extends \Model { 
	public $_table ='pm_issues_types';  
 	 public $_fields = [
	 'pm_issue_type_id' =>  ['int',11,'PRI'],
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
 