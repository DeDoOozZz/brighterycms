<?php namespace modules\store\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * Modules Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Modules extends \Model {

    public $_table = 'modules';
    public $_fields = [
        'module_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 255],
        'status' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
                'status' => ['enum', ['pending', 'active', 'banned']],
            ],
        ];
    }

    public function fields() {
        return [
            'name' => 'Name',
            'code' => 'Image',
            'status' => 'Status',
        ];
    }

}
