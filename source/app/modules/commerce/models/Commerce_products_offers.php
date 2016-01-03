<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Products Offers Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_products_offers extends \Model {

    public $_table = 'commerce_products_offers';
    public $_fields = [
        'commerce_products_offer_id' => ['int', 11, 'PRI'],
        'title' => ['varchar', 255],
        'commerce_product_id' => ['int', 11],
        'offer_image' => ['varchar', 255],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
//                'offer_image' => array('required'),
                'commerce_product_id' => ['required'],
            ],
            'add' => [
                'offer_image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                ]
                ],
            ],
            'edit' => [
                'offer_image' => ['file' => [
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
            'title' => 'title',
            'offer_image' => 'offer_image',
            'commerce_product_id' => 'product_id',
        ];
    }

}
