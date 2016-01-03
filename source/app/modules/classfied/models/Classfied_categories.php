<?php

namespace modules\classfied\models;

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Categories Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Classfied_categories extends \Model {

    public $_table = 'classfied_categories';
    public $_fields = [
        'classfied_category_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 32],
        'var_name' => ['varchar', 32],
        'title' => ['text'],
        'description' => ['text'],
        'keywords' => ['text'],
        'category_order' => ['int', 11],
        'icon' => ['text'],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
                'var_name' => ['required'],
                'title' => ['required'],
            ],
            'add' => [
                'icon' => ['file' => [
                        [
                            'upload_path' => "./cdn/classfied/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                    ]],
            ]
            ,
            'edit' => [
                'icon' => ['file' => [
                        [
                            'upload_path' => "./cdn/classfied/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                    ]],
        ]];
    }

    public function fields() {
        return [
            'classfied_category_id' => 'ID',
            'name' => 'Name',
            'var_name' => 'Var Name',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywordsge',
            'category_order' => 'Category Order',
            'icon' => 'Icon',
        ];
    }

}
