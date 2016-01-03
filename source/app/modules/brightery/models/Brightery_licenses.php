<?php

namespace modules\brightery\models;

defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Brightery_licenses
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Brightery_licenses
 * @model Settings
 **/
 
class  Brightery_licenses extends \Model { 
	public $_table ='brightery_licenses';  
 	 public $_fields = [ 
	 'brightery_license_id' =>  ['int',10,'PRI'], 
	 'license_code' =>  ['varchar',50], 
	 'brightery_product_id' =>  ['int',10], 
	 'domain' =>  ['varchar',50], 
	 'data' =>  ['text'], 
	 'user_id' =>  ['int',11], 
	 'payment_type' =>  ['enum',['fixed','subscription']], 
	 'brightery_products_subscription_id' =>  ['int',11], 
	];   
 
 
	public function rules() {
        return [ 	
        'all' => [ 
 	 'license_code' =>['required'], 
 	 'brightery_product_id' =>['required', 'numeric'], 
 	 'domain' =>['required'], 
// 	 'data' =>['required'], 
 	 'user_id' =>['required', 'numeric'], 
 	 'payment_type' =>['required'], 
// 	 'brightery_products_subscription_id' =>['numeric'], 
	 ], 	];   
 
 
} 
 
 
	public function fields() {
        return [ 
	 'license_code' =>'license code', 
	 'brightery_product_id' =>'brightery product id', 
	 'domain' =>'domain', 
	 'data' =>'data', 
	 'user_id' =>'user id', 
	 'payment_type' =>'payment type', 
	 'brightery_products_subscription_id' =>'brightery products subscription id', 
	];
    }
} 
 