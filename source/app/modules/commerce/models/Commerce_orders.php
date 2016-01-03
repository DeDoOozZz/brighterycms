<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Orders Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_orders extends \Model {

    public $_table = 'commerce_orders';
    public $_fields = [
        'commerce_order_id' => ['int', 11, 'PRI'],
        'subtotal' => ['float'],
        'total' => ['float'],
        'commerce_payment_method_id' => ['int', 11, 'MUL'],
        'user_id' => ['int', 11, 'MUL'],
        'billing_address' => ['text'],
        'shipping_address' => ['text'],
        'status' => ['enum', ['pending', 'confirmed']],
    ];

    public function rules() {
        return [
            'order' => [

                'commerce_payment_method_id' => ['required', 'numeric'],
                'billing_address' => ['required'],
                'shipping_address' => ['required'],
            ],
            'manage' => [
                'subtotal' => ['required'],
                'total' => ['required'],
                'commerce_payment_method_id' => ['required', 'numeric'],
                'user_id' => ['required', 'numeric'],
                'billing_address' => ['required'],
                'shipping_address' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'subtotal' => 'subtotal',
            'total' => 'total',
            'commerce_payment_method_id' => 'Payment Method',
            'user_id' => 'user id',
            'billing_address' => 'Billing Address',
            'shipping_address' => 'Shipping Address',
        ];
    }

}
