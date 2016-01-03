<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author 
 * @version 1.0
 * @module Clinic_doctor_reviews
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_doctor_reviews
 * @model Settings
 * */
class Clinic_doctor_reviews extends \Model {

    public $_table = 'clinic_doctor_reviews';
    public $_fields = [
        'clinic_doctor_review_id' => ['int', 11, 'PRI'],
        'review' => ['tinyint', 4],
        'clinic_patient_id' => ['int', 11],
        'clinic_doctor_id' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'review' => ['required'],
                'clinic_patient_id' => ['required', 'numeric'],
                'clinic_doctor_id' => ['required', 'numeric'],
            ],];
    }

    public function fields() {
        return [
            'review' => 'review',
            'clinic_patient_id' => 'clinic patient id',
            'clinic_doctor_id' => 'clinic doctor id',
        ];
    }

}
