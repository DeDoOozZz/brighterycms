<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Product Detail Options Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */

class  Commerce_product_detail_options extends \Model { 
	public $_table ='commerce_product_detail_options';  
 	 public $_fields = [
	 'commerce_product_detail_option_id' =>  ['int',11,'PRI'],
	 'commerce_product_detail_id' =>  ['int',11,'MUL'],
	 'name' =>  ['text'],
	 'price' =>  ['double'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'commerce_product_detail_id' => ['required', 'numeric'],
 	 'name' => ['required'],
 	 'price' => ['required'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'commerce_product_detail_id' =>'commerce product detail id', 
	 'name' =>'name', 
	 'price' =>'price',
		];
    }
} 
 