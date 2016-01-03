<?php
namespace modules\brightery\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * @package Brightery CMS
 * @author 
 * @version 1.0
 * @module Brightery_products_subscriptions
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Brightery_products_subscriptions
 * @model Settings
 * */
class Brightery_products_subscriptions extends \Model {

    public $_table = 'brightery_products_subscriptions';
    public $_fields = [
        'brightery_products_subscription_id' => ['int', 11, 'PRI'],
        'brightery_product_id' => ['int', 11],
        'price' => ['double'],
        'period_cycle' => ['varchar', 10],
        'period' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
            ],];
    }

    public function fields() {
        return [
            'brightery_product_id' => 'brightery product id',
            'price' => 'price',
        ];
    }

}
