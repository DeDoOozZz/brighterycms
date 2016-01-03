<?php namespace modules\classfied\models; defined('ROOT') OR exit('No direct script access allowed');


/**
 * Classfied countries Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Classfied_countries extends \Model {

    public $_table = 'classfied_countries';
    public $_fields = [
        'classfied_country_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 50],
        'image' => ['text'],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
            ],
            'add' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/classfied",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                    ]],
            ],
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/classfied",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                    ]],
        ]];
    }

    public function fields() {
        return [
            'name' => 'name',
            'image' => 'image',
        ];
    }

}
