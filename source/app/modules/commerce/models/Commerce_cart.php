<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Cart Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */

class  Commerce_cart extends \Model { 
	public $_table ='commerce_cart';  
 	 public $_fields = [
	 'commerce_cart_id' =>  ['int',11,'PRI'],
	 'commerce_product_id' =>  ['int',11,'MUL'],
	 'user_id' =>  ['int',11,'MUL'],
	 'weight' =>  ['float'],
	 'qty' =>  ['int',11],
	 'options' =>  ['text'],
	 'datetime' =>  ['datetime'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'commerce_product_id' => ['required', 'numeric'],
 	 'user_id' => ['required', 'numeric'],
 	 'weight' => ['required'],
 	 'qty' => ['required', 'numeric'],
 	 'options' => ['required'],
 	 'datetime' => ['required', 'datetime'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'commerce_product_id' =>'commerce product id', 
	 'user_id' =>'user id', 
	 'weight' =>'weight', 
	 'qty' =>'qty', 
	 'options' =>'options', 
	 'datetime' =>'datetime',
		];
    }
} 
 