<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic_doctors
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_doctors
 * @model Settings
 * */
class Clinic_doctors extends \Model {

    public $_table = 'clinic_doctors';
    public $_fields = [
        'clinic_doctor_id' => ['int', 11, 'PRI'],
        'clinic_specification_id' => ['int', 11],
        'description' => ['text'],
        'user_id' => ['int', 11],
        'period_average' => ['varchar', 2],
    ];

    public function rules() {
        return [
            'all' => [
                'clinic_specification_id' => ['required'],
                'user_id' => ['required', 'numeric'],
                'description'=>['required'],
                'period_average'=>['required','numeric']


            ],];
    }

    public function fields() {
        return [
            'clinic_specification_id' => 'clinic specification id',
            'description' => 'description',
            'user_id' => 'user id',
            'period_average' => 'period average',
        ];
    }

}
