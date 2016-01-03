<?php
namespace modules\pm\models;            
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_issue_statues
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_issue_statues
 * @model Settings
 **/

class  Pm_issue_statues extends \Model { 
	public $_table ='pm_issue_statues';  
 	 public $_fields = [
	 'pm_issue_statues_id' =>  ['int',11,'PRI'],
	 'title' =>  ['varchar',225],
	 'color' =>  ['varchar',225],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
	 'title' => array('required'), 
 	 'color' => array('required'), 
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'title' =>'title', 
	 'color' =>'color',
		];
    }


} 
 