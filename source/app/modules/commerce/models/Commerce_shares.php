<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Shares Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_shares extends \Model {

    public $_table = 'commerce_shares';
    public $_fields = [
        'commerce_shares_id' => ['int', 11, 'PRI'],
        'from_title' => ['varchar', 255],
        'from_description' => ['text'],
        'from_image' => ['text'],
        'location' => ['varchar', 255],
        'user_id' => ['int', 11],
        'to_title' => ['varchar', 255],
        'to_description' => ['text'],
        'to_image' => ['text'],
    ];

    public function rules() {
        return [
            'all' => [
                'from_title' => ['required'],
                'from_description' => ['required'],
//                'location' => ['required'],
                'to_title' => ['required'],
                'to_description' => ['required'],
            ],
            'add' => [
                'user_id' => ['required'],
                'from_image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'required' => TRUE
                        ]
                ]
                ],
                'to_image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'required' => FALSE
                        ]
                ]
                ]
            ],
            'edit' => [
                'user_id' => ['required'],
                'from_image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'required' => FALSE
                        ]
                ]
                ],
                'to_image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'required' => FALSE
                        ]
                ]
                ]
            ],
            'frontend_add' => [
                'from_image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'required' => TRUE
                        ]
                ]],
                'to_image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'required' => FALSE
                        ]
                ]]
            ],
        ];
    }

    public function fields() {
        return [
            'from_title' => 'from_title',
            'from_description' => 'from_description',
            'from_image' => 'from_image',
            'location' => 'location',
            'user_id' => 'user_id',
            'to_title' => 'to_title',
            'to_description' => 'to_description',
            'to_image' => 'to_image',
        ];
    }

}
