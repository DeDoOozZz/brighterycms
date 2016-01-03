<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic_patients
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_patients
 * @model Settings
 * */
class Clinic_patients extends \Model {

    public $_table = 'clinic_patients';
    public $_fields = [
        'clinic_patient_id' => ['int', 11, 'PRI'],
        'birthdate' => ['date'],
        'note' => ['text'],
        'user_id' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'birthdate' => ['required'],
                'note' => ['required'],
//                'user_id' => ['required', 'numeric'],
            ],
        ];
    }

    public function fields() {
        return [
            'birthdate' => 'birthdate',
            'note' => 'note',
            'user_id' => 'user id',
        ];
    }

}
