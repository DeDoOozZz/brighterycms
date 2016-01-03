<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic_patients_notes
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_patients_notes
 * @model Clinic_patients_notes
 * */
class Clinic_patients_notes extends \Model {

    public $_table = 'clinic_patients_notes';
    public $_fields = [
        'clinic_patient_note_id' => ['int', 11, 'PRI'],
        'clinic_doctor_id' => ['int', 11],
        'user_id' => ['int', 11],
        'note' => ['text'],
    ];

    public function rules() {
        return [
            'all' => [
// 	 'clinic_doctor_id' =>['required', 'numeric'], 
// 	 'user_id' =>['required', 'numeric'], 
                'note' => ['required'],
            ],];
    }

    public function fields() {
        return [
            'clinic_doctor_id' => 'clinic doctor id',
            'user_id' => 'user id',
            'note' => 'note',
        ];
    }

}
