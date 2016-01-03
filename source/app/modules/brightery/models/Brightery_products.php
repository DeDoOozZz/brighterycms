<?php

namespace modules\brightery\models;

defined('ROOT') OR exit('No direct script access allowed');

/**
 * @package Brightery CMS
 * @author 
 * @version 1.0
 * @module Brightery_products
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Brightery_products
 * @model Settings
 * */
class Brightery_products extends \Model {

    public $_table = 'brightery_products';
    public $_fields = [
        'brightery_product_id' => ['int', 10, 'PRI'],
        'title' => ['varchar', 50],
        'fixed_price_status' => ['tinyint', 4],
        'fixed_price' => ['double'],
        'subscription_price_status' => ['tinyint', 4],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
                'fixed' => ['validate_price'],
                'sfixed' => ['validate_p'],
            ],];
    }

    public function fields() {
        return [
            'brightery_product_id' => 'brightery product id',
            'title' => 'title',
            'fixed_price_status' => 'fixed_price_status',
            'fixed_price' => 'fixed_price',
            'subscription_price_status' => 'subscription_price_status',
        ];
    }

    function _validate_price($str = null) {
        $status = 0;
        if ($this->input->post('fixed') == 1)
            $status = '1';
        if ($this->input->post('sfixedd') == 1)
            $status = '1';

        if ($status == 0) {
            $this->validation->setValidationMessage('validate_price', 'select fixed or subscipton');
            return false;
        }
        if ($this->input->post('fixed') == 1) {
            if (!$this->input->post('fixed_price')) {
                $this->validation->setValidationMessage('validate_price', 'fixed price required');
                return false;
            }
        }



        return true;
    }

    function _validate_p() {
        if ($this->input->post('sfixedd') == 1) {
            if (!$this->input->post('price')) {

                $this->validation->setValidationMessage('validate_p', 'add at least one row in subscrition');
                return false;
            }
            foreach ($this->input->post('n') as $item) {
                if (!$item) {
                    $this->validation->setValidationMessage('validate_p', 'subscription period required');
                    return false;
                }
            }
            foreach ($this->input->post('s') as $item) {
                if (!$item) {
                    $this->validation->setValidationMessage('validate_p', 'subscription cycle required');
                    return false;
                }
            }

            foreach ($this->input->post('price') as $item) {
                if (!$item) {
                    $this->validation->setValidationMessage('validate_p', 'subscription price required');
                    return false;
                }
                if($item){
                if(!filter_var($item,FILTER_VALIDATE_FLOAT))
                {
                       $this->validation->setValidationMessage('validate_p', 'subscription price must be number');
                       return FALSE;
                }
                }
            }
        }
        return true;
    }

}
