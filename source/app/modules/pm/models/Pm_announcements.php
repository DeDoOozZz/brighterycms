<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_announcements
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_announcements
 * @model Settings
 **/

class  Pm_announcements extends \Model { 
	public $_table ='pm_announcements';  
 	 public $_fields = [
	 'pm_announce_id' =>  ['int',11,'PRI'],
	 'title' =>  ['varchar',225],
	 'content' =>  ['longtext'],
	 'time' =>  ['datetime'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'title' => ['required'],
 	 'content' => ['required'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'title' =>'title', 
	 'content' =>'content', 
	 'time' =>'time',
		];
    }
} 
 