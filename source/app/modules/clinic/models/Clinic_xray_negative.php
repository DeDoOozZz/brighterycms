<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Clinic_xray_negative
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_xray_negative
 * @model Clinic_xray_negative
 * */
class Clinic_xray_negative extends \Model {

    public $_table = 'clinic_xray_negative';
    public $_fields = [
        'clinic_xray_negative_id' => ['int', 11, 'PRI'],
        'title' => ['varchar', 255],
        'description' => ['text'],
        'user_id' => ['int', 11],
        'image' => ['text'],
        'created' => ['datetime'],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
// 	 'description' =>['required'], 
// 	 'user_id' => ['required', 'numeric'],
//         'image' => ['required'],
            ], 'add' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/clinic_xray_negative",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                    ]],
            ]
            ,
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/clinic_xray_negative",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                    ]],
            ]
        ];
    }

    public function fields() {
        return [
            'title' => 'title',
            'description' => 'description',
            'user_id' => 'user id',
            'image' => 'image',
            'created' => 'created',
        ];
    }

}
