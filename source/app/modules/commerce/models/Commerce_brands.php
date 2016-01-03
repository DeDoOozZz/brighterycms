<?php

namespace modules\commerce\models;

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Brands Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_brands extends \Model {

    public $_table = 'commerce_brands';
    public $_fields = [
        'commerce_brand_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 45],
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
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                    ]
                ],
            ],
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                    ]
                ],
            ],
        ];
    }

    public function fields() {
        return [
            'name' => 'name',
            'image' => 'Image',
        ];
    }

}
