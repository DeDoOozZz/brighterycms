<?php namespace modules\users\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * @package Brightery CMS
 * @author
 * @version 1.0
 * @module User_addresses
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/User_addresses
 * @model User_addresses
 **/
class User_addresses extends \Model
{
    public $_table = 'user_addresses';
    public $_fields = array(
        'user_address_id' => array('int', 11, 'PRI'),
        'zipcode' => array('varchar', 5),
        'city_id' => array('int', 11),
        'address' => array('text'),
        'user_id' => array('int', 11, 'MUL'),
        'type' => array('enum', ['shipping', 'billing']),
        'primary' => array('tinyint', 4),
    );


    public function rules()
    {
//        return array(
//            'not' => array(
//                'zipcode' => array('required'),
//                'city_id' => array('required', 'numeric'),
//                'address' => array('required'),
//                'user_id' => array('required', 'numeric'),
//                'type' => array('required'),
//                'primary' => array('required'),
//            ),);


    }


    public function fields()
    {
        return array(
            'zipcode' => 'zipcode',
            'city_id' => 'city id',
            'address' => 'address',
            'user_id' => 'user id',
            'type' => 'type',
            'primary' => 'primary',
        );
    }
} 
 