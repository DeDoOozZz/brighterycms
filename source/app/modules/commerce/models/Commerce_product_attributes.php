<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Product Attributes Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */


class  Commerce_product_attributes extends \Model { 
	public $_table ='commerce_product_attributes';  
 	 public $_fields = [
	 'commerce_product_attribute_id' =>  ['int',11,'PRI'],
	 'commerce_category_attribute_id' =>  ['int',11,'MUL'],
	 'value' =>  ['text'],
	 'commerce_product_id' =>  ['int',11,'MUL'],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'commerce_category_attribute_id' => ['required', 'numeric'],
 	 'value' => ['required'],
 	 'commerce_product_id' => ['required', 'numeric'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'commerce_category_attribute_id' =>'commerce category attribute id', 
	 'value' =>'value', 
	 'commerce_product_id' =>'commerce product id',
		];
    }
} 
 