<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_sessions
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_sessions
 * @model Settings
 **/

class  Pm_sessions extends \Model { 
	public $_table ='pm_sessions';  
 	 public $_fields = [
	 'pm_session_id' =>  ['int',11,'PRI'],
	 'ip_address' =>  ['varchar',50],
	 'user_agent' =>  ['varchar',150],
	 'last_activity' =>  ['int',11],
	 'user_data' =>  ['text'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'ip_address' => ['required'],
 	 'user_agent' => ['required'],
 	 'last_activity' => ['required', 'numeric'],
 	 'user_data' => ['required'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'ip_address' =>'ip address', 
	 'user_agent' =>'user agent', 
	 'last_activity' =>'last activity', 
	 'user_data' =>'user data',
		];
    }
} 
 