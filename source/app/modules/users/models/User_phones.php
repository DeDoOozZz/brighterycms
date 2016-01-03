<?php namespace modules\users\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * User Phones Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 * @version 1.0
 * */
class User_phones extends \Model {

    public $_table = 'user_phones';
    public $_fields = [
        'user_phone_id' => ['int', 11, 'PRI'],
        'primary' => ['tinyint', 4],
        'phone' => ['varchar', 45],
        'user_id' => ['int', 11, 'MUL'],
    ];

    public function rules() {
        return [
            'all' => [
            ],];
    }

    public function fields() {
        return [
            'primary' => 'primary',
            'phone' => 'phone',
            'user_id' => 'user id',
        ];
    }

}
