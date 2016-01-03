<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_projects
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_projects
 * @model Settings
 **/

class  Pm_projects extends \Model { 
	public $_table ='pm_projects';  
 	 public $_fields = [
	 'pm_project_id' =>  ['int',11,'PRI'],
	 'title' =>  ['varchar',100],
	 'about' =>  ['longtext'],
	 'tags' =>  ['varchar',100],
	 'creation_time' =>  ['datetime'],
	 'pm_supervisor_id' =>  ['int',11],
	 'pm_client_id' =>  ['int',11],
	 'deadline' =>  ['datetime'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'title' => ['required'],
 	 'about' => ['required'],
// 	 'creation_time' => array('required', 'datetime'),
// 	 'pm_supervisor_id' => array('required', 'numeric'),
// 	 'pm_client_id' => array('required', 'numeric'),
// 	 'deadline' => array('required', 'datetime'),
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'title' =>'title', 
	 'about' =>'about', 
	 'tags' =>'tags',
	 'creation_time' =>'creation time',
	 'pm_supervisor_id' =>'pm supervisor id', 
	 'pm_client_id' =>'pm client id', 
	 'deadline' =>'deadline',
		];
    }
} 
 