<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_clients
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_clients
 * @model Settings
 **/

class  Pm_clients extends \Model { 
	public $_table ='pm_clients';  
 	 public $_fields = [
	 'pm_client_id' =>  ['int',11,'PRI'],
	 'name' =>  ['varchar',100],
	 'image' =>  ['varchar',225],
	 'mobile' =>  ['varchar',100],
	 'job' =>  ['varchar',100],
	 'work_address' =>  ['varchar',200],
	 'company_name' =>  ['varchar',150],
	 'join_date' =>  ['datetime'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'name' => ['required'],
'image' => ['required'],
 	 'mobile' => ['required'],
 	 'job' => ['required'],
 	 'work_address' => ['required'],
 	 'company_name' => ['required'],
 	 'join_date' => ['required', 'datetime'],
		],	 'add' => [
                'image' => ['file' => [
                    [
                        'upload_path' => "./cdn/pm_clients",
                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                       'required' => TRUE
					]
				]],
			]
,
                'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' =>  "./cdn/pm_clients",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
						]
				]],

				]];
 
 
} 
 
 
	public function fields() {
        return [
	 'name' =>'name', 
	 'image' =>'image', 
	 'mobile' =>'mobile', 
	 'job' =>'job', 
	 'work_address' =>'work address', 
	 'company_name' =>'company name', 
	 'join_date' =>'join date',
		];
    }
} 
 