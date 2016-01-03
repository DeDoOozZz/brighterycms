<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_reputations
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_reputations
 * @model Settings
 **/

class  Pm_reputations extends \Model { 
	public $_table ='pm_reputations';  
 	 public $_fields = [
	 'pm_reputation_id' =>  ['int',11,'PRI'],
	 'user_id' =>  ['int',11],
	 'pm_issue_id' =>  ['int',11],
	 'reason' =>  ['longtext'],
	 'time' =>  ['datetime'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'reason' => ['required'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'user_id' =>'user id', 
	 'pm_issue_id' =>'pm issue id', 
	 'reason' =>'reason', 
	 'time' =>'time',
		];
    }
} 
 