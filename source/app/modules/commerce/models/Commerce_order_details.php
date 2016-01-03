<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Order Details Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_order_details extends \Model {

    public $_table = 'commerce_order_details';
    public $_fields = [
        'commerce_order_detail_id' => ['int', 11, 'PRI'],
        'commerce_order_id' => ['int', 11],
        'option' => ['text'],
        'qty' => ['int', 11],
        'weight' => ['float'],
        'commerce_product_id' => ['int', 11, 'MUL'],
        'price' => ['double'],
        'product_total' => ['double'],
    ];

    public function rules() {
        return [
            'all' => [
                'option' => ['required'],
                'qty' => ['required', 'numeric'],
                'weight' => ['required'],
                'commerce_product_id' => ['required', 'numeric'],
                'price' => ['required'],
                'product_total' => ['required'],
                'commerce_order_id' => ['required'],
            ],];
    }

    public function fields() {
        return [
            'option' => 'option',
            'qty' => 'qty',
            'weight' => 'weight',
            'commerce_product_id' => 'commerce product id',
            'price' => 'price',
            'product_total' => 'product total',
            'commerce_order_id' => 'Order id',
        ];
    }

    public function getOrderProducts($id) {
        return $this->Database->query("SELECT commerce_order_details.* , `commerce_products`.`name`"
                        . "FROM `commerce_order_details` "
                        . "JOIN `commerce_products` ON `commerce_products`.`commerce_product_id`=`commerce_order_details`.`commerce_product_id`"
                        . "WHERE commerce_order_id = '$id'")->result();
    }

}
