<?php namespace modules\clinic\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic_schedule_exceptions
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_schedule_exceptions
 * @model Clinic_schedule_exceptions
 * */
class Clinic_schedule_exceptions extends \Model {

    public $_table = 'clinic_schedule_exceptions';
    public $_fields = [
        'clinic_schedule_exception_id' => ['int', 11, 'PRI'],
        'clinic_doctor_id' => ['int', 11],
        'date' => ['date'],
        'from_time' => ['datetime'],
        'to_time' => ['datetime'],
    ];

    public function rules() {
        return [
            'all' => [
//                'clinic_doctor_id' => ['required', 'numeric'],
//                'date' => ['required'],
//                'from_time' => ['required'],
//                'to_time' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'clinic_doctor_id' => 'clinic_schedule_id',
            'date' => 'date',
            'from_time' => 'from_time',
            'to_time' => 'to_time',
        ];
    }

}
