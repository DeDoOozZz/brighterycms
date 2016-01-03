<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Wishlist Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */

class  Commerce_wishlist extends \Model { 
	public $_table ='commerce_wishlist';  
 	 public $_fields = [
	 'commerce_wishlist_id' =>  ['int',11,'PRI'],
	 'user_id' => ['int',11],
	 'commerce_product_id' =>  ['int',11],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'commerce_wishlist_id' => ['required'],
 	 'user_id' => ['required', 'numeric'],
 	 'commerce_product_id' => ['required'],
		],];
 
} 
 
	public function fields() {
        return [
	 'commerce_wishlist_id' =>'commerce_wishlist_id', 
	 'user_id' =>'user_id', 
	 'commerce_product_id' =>'commerce_product_id',
		];
    }
} 
 