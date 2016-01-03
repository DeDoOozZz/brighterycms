<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic_specifications
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_specifications
 * @model Clinic_specifications
 * */
class Clinic_specifications extends \Model {

    public $_table = 'clinic_specifications';
    public $_fields = [
        'clinic_specification_id' => ['int', 11, 'PRI'],
        'specification' => ['varchar', 255],
        'description' => ['text'],
    ];

    public function rules() {
        return [
            'all' => [
                'specification' => ['required'],
                'description' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'specification' => 'specification',
            'description' => 'Description',
        ];
    }

}
