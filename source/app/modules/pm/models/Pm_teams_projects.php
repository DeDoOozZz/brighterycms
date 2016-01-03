<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_teams_projects
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_teams_projects
 * @model Settings
 **/

class  Pm_teams_projects extends \Model { 
	public $_table ='pm_teams_projects';  
 	 public $_fields = [
	 'pm_team_project_id' =>  ['int',11,'PRI'],
	 'pm_project_id' =>  ['int',11],
	 'pm_team_id' =>  ['int',11],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'pm_project_id' => ['required', 'numeric'],
 	 'pm_team_id' => ['required', 'numeric'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'pm_project_id' =>'pm project id', 
	 'pm_team_id' =>'pm team id',
		];
    }
} 
 