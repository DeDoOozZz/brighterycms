<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic_doctor_reservation_types
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_doctor_reservation_types
 * @model Settings
 * */
class Clinic_doctor_reservation_types extends \Model {

    public $_table = 'clinic_doctor_reservation_types';
    public $_fields = [
        'clinic_doctor_reservation_type_id' => ['int', 11, 'PRI'],
        'title' => ['varchar', 250],
        'price' => ['double'],
        'clinic_doctor_id' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
                'price' => ['required'],
                'clinic_doctor_id' => ['required', 'numeric'],
            ],];
    }

    public function fields() {
        return [
            'title' => 'title',
            'price' => 'price',
            'clinic_doctor_id' => 'clinic doctor id',
        ];
    }

}
