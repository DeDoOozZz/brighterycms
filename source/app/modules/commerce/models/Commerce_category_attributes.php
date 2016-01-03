<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Categories Attributes Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_category_attributes extends \Model {

    public $_table = 'commerce_category_attributes';
    public $_fields = [
        'commerce_category_attribute_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 45],
        'commerce_category_id' => ['int', 11, 'MUL'],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
                'commerce_category_id' => ['required', 'numeric'],
            ],];
    }

    public function fields() {
        return [
            'name' => 'name',
            'commerce_category_id' => 'commerce category id',
        ];
    }

}
