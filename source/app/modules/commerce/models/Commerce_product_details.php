<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Product details Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */


class  Commerce_product_details extends \Model { 
	public $_table ='commerce_product_details';  
 	 public $_fields = [
	 'commerce_product_detail_id' =>  ['int',11,'PRI'],
	 'name' =>  ['text'],
	 'commerce_product_id' =>  ['int',11,'MUL'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'name' => ['required'],
 	 'commerce_product_id' => ['required', 'numeric'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'name' =>'name', 
	 'commerce_product_id' =>'commerce product id',
		];
    }
} 
 