<?php
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Users
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Users
 * @model Settings
 **/
 
class  Users extends Model { 
	public $_table ='users';  
 	 public $_fields = [ 
	 'user_id' =>  ['int',11,'PRI'], 
	 'fullname' =>  ['varchar',255], 
	 'email' =>  ['varchar',255,'UNI'], 
	 'password' =>  ['varchar',32], 
	 'image' =>  ['text'], 
	 'usergroup_id' =>  ['int',11], 
	 'joindate' =>  ['datetime'], 
	 'google_id' =>  ['varchar',300], 
	 'facebook_id' =>  ['varchar',300], 
	 'facebook_access_token' =>  ['text'], 
	 'status' =>  ['enum',['pending','active','banned']], 
	 'gender' =>  ['enum',['male','female']], 
	 'birthdate' =>  ['date'], 
	];   
 
 
	public function rules() {
        return [ 	
        'all' => [ 
 	 'fullname' =>['required'], 
 	 'email' =>['required'], 
 	 'password' =>['required'], 
'image' => ['required'],
 	 'usergroup_id' =>['required', 'numeric'], 
 	 'joindate' =>['required', 'datetime'], 
 	 'google_id' =>['required'], 
 	 'facebook_id' =>['required'], 
 	 'facebook_access_token' =>['required'], 
 	 'status' =>['required'], 
 	 'gender' =>['required'], 
 	 'birthdate' =>['required'], 
	 ],	 'add' => [
                'image' => ['file' => [
                    [
                        'upload_path' => "./cdn/users",
                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                       'required' => TRUE
                    ]
                ]], 
 ] 
,
                'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' =>  "./cdn/users",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                    ]],
                
 ] 	];   
 
 
} 
 
 
	public function fields() {
        return [ 
	 'fullname' =>'fullname', 
	 'email' =>'email', 
	 'password' =>'password', 
	 'image' =>'image', 
	 'usergroup_id' =>'usergroup id', 
	 'joindate' =>'joindate', 
	 'google_id' =>'google id', 
	 'facebook_id' =>'facebook id', 
	 'facebook_access_token' =>'facebook access token', 
	 'status' =>'status', 
	 'gender' =>'gender', 
	 'birthdate' =>'birthdate', 
	];
    }
} 
 