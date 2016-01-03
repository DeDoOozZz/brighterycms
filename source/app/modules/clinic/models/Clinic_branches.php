<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic Branches
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_branches
 * @model Settings
 * */
class Clinic_branches extends \Model {

    public $_table = 'clinic_branches';
    public $_fields = [
        'clinic_branch_id' => ['int', 11, 'PRI'],
        'clinic_branch' => ['varchar', 255],
        'phone' => ['varchar', 255],
        'address' => ['text'],
        'longitude' => ['varchar', 255],
        'latitude' => ['varchar', 255],
        'description' => ['text'],
    ];

    public function rules() {
        return [
            'all' => [
                'clinic_branch' => ['required'],
                'phone' => ['required','phone'],
                'address' => ['required'],
                'longitude' => ['numeric'],
                'latitude' => ['numeric'],
                'description' => ['required'],
            ],];
    }

    public function fields() {
        return [
            'clinic_branch' => 'Branch Name',
            'phone' => 'phone',
            'address' => 'address',
            'longitude' => 'longitude',
            'latitude' => 'latitude',
            'description' => 'description',
        ];
    }

}
