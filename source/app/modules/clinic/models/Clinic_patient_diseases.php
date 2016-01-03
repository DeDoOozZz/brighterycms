<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic_patient_diseases
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_patient_diseases
 * @model Settings
 * */
class Clinic_patient_diseases extends \Model {

    public $_table = 'clinic_patient_diseases';
    public $_fields = [
        'clinic_patient_disease_id' => ['int', 11, 'PRI'],
        'user_id' => ['int', 11],
        'clinic_disease_template_id' => ['int', 11],
        'note' => ['text'],
    ];

    public function rules() {
        return [
            'all' => [
// 	 'clinic_patient_id' =>['required', 'numeric'], 
// 	 'clinic_disease_template_id' =>['required', 'numeric'], 
                'note' => ['required'],
            ],];
    }

    public function fields() {
        return [
            'user_id' => 'User',
            'clinic_disease_template_id' => 'clinic disease template id',
            'note' => 'note',
        ];
    }

}
