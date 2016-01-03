<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_infractions
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_infractions
 * @model Settings
 **/

class  Pm_infractions extends \Model { 
	public $_table ='pm_infractions';  
 	 public $_fields = [
	 'pm_infraction_id' =>  ['int',11,'PRI'],
	 'user_id' =>  ['int',11],
	 'pm_issue_id' =>  ['int',11],
	 'reson' =>  ['text'],
	 'time' =>  ['datetime'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'reson' => ['required'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'user_id' =>'user id', 
	 'pm_issue_id' =>'pm issue id', 
	 'reson' =>'reson', 
	 'time' =>'time',
		];
    }
} 
 