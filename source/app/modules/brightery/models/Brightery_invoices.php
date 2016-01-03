<?php
namespace modules\brightery\models;            
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Brightery_invoices
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Brightery_invoices
 * @model Settings
 **/

class  Brightery_invoices extends \Model { 
	public $_table ='brightery_invoices';  
 	 public $_fields = [
	 'brightery_invoice_id' =>  ['int',11,'PRI'],
	 'brightery_license_id' =>  ['int',11],
	 'due_date' =>  ['date'],
	 'status' =>  ['enum',['due','paid','canceled']],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'brightery_license_id' => ['required', 'numeric'],
 	 'due_date' => ['required'],
 	 'status' => ['required'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'brightery_license_id' =>'brightery license id', 
	 'due_date' =>'due date', 
	 'status' =>'status',
		];
    }
} 
 