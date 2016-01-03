<?php

namespace modules\commerce\models;

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Payment Method Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_payment_method extends \Model {

    public $_table = 'commerce_payment_method';
    public $_fields = [
        'commerce_payment_method_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 45],
        'fees' => ['double'],
        'settings' => ['text'],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
                'fees' => ['required'],
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
            'fees' => 'fees',
            'settings' => 'settings',
        ];
    }

}
