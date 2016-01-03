<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Product Images Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_product_images extends \Model {

    public $_table = 'commerce_product_images';
    public $_fields = [
        'commerce_product_image_id' => ['int', 11, 'PRI'],
        'product_image' => ['text'],
        'primary' => ['tinyint', 1],
        'commerce_product_id' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
//                'product_image' => ['product_image'],
                'primary' => ['required'],
                'commerce_product_id' => ['required'],
            ],];
    }

    public function fields() {
        return [
            'product_image' => 'product_image',
            'primary' => 'primary',
            'commerce_product_id' => 'commerce_product_id',
        ];
    }

}
