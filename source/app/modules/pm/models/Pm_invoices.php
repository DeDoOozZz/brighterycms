<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
* @version 1.0
* @module Pm_invoices
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Pm_invoices
 * @model Settings
 **/

class  Pm_invoices extends \Model { 
	public $_table ='pm_invoices';  
 	 public $_fields = [
	 'pm_invoice_id' =>  ['int',11,'PRI'],
	 'total' =>  ['double'],
	 'paid' =>  ['double'],
	 'pm_project_id' =>  ['int',11],
	 'pm_client_id' =>  ['int',11],
	 ];
 
 
	public function rules() {
        return [
        'all' => [
 	 'total' => ['required'],
 	 'paid' => ['required'],
 	 'pm_project_id' => ['required', 'numeric'],
 	 'pm_client_id' => ['required', 'numeric'],
		],];
 
 
} 
 
 
	public function fields() {
        return [
	 'total' =>'total', 
	 'paid' =>'paid', 
	 'pm_project_id' =>'pm project id', 
	 'pm_client_id' =>'pm client id',
		];
    }
} 
 