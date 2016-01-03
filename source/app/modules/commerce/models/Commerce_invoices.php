<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Invoices Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_invoices extends \Model {

    public $_table = 'commerce_invoices';
    public $_fields = [
        'commerce_invoice_id' => ['int', 11, 'PRI'],
        'commerce_order_id' => ['int', 11, 'MUL'],
        'status' => ['enum', ['paied', 'unpaied']],
    ];

    public function rules() {
        return [
            'all' => [
                'commerce_order_id' => ['required', 'numeric'],
                'status' => ['required'],
            ],];
    }

    public function fields() {
        return [
            'commerce_order_id' => 'commerce order id',
            'status' => 'status',
        ];
    }

}
