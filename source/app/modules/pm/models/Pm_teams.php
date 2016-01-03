<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_teams
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_teams
 * @model Settings
 **/

class  Pm_teams extends \Model { 
	public $_table ='pm_teams';  
 	 public $_fields = [
	 'pm_team_id' =>  ['int',11,'PRI'],
	 'title' =>  ['varchar',225],
	 'description' =>  ['longtext'],
	 'pm_team_leader_id' =>  ['int',11],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'title' => ['required'],
 	 'description' => ['required'],
// 	 'pm_team_leader_id' => array('required', 'numeric'),
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'title' =>'title', 
	 'description' =>'description', 
	 'pm_team_leader_id' =>'pm team leader id',
		];
    }
} 
 