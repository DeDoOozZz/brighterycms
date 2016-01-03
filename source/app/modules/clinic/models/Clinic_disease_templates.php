<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic_disease_templates
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_disease_templates
 * @model Clinic_disease_templates
 * */
class Clinic_disease_templates extends \Model {

    public $_table = 'clinic_disease_templates';
    public $_fields = [
        'clinic_disease_template_id' => ['int', 11, 'PRI'],
        'title' => ['varchar', 255],
        'content' => ['text'],
        'language_id' => ['varchar', 3],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
                'content' => ['required'],
                'language_id' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'title' => 'title',
            'content' => 'content',
            'language_id' => 'language_id',
        ];
    }

}
