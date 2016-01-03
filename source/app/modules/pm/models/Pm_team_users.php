<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_team_users
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_team_users
 * @model Settings
 **/

class  Pm_team_users extends \Model { 
	public $_table ='pm_team_users';  
 	 public $_fields = [
	 'pm_team_users_id' =>  ['int',11,'PRI'],
	 'pm_team_id' =>  ['int',11],
	 'user_id' =>  ['int',11],
	 'pm_role_id' =>  ['int',11],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'pm_team_id' => ['required', 'numeric'],
 	 'user_id' => ['required', 'numeric'],
 	 'pm_role_id' => ['required', 'numeric'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'pm_team_id' =>'pm team id', 
	 'user_id' =>'user id', 
	 'pm_role_id' =>'pm role id',
		];
    }
} 
 