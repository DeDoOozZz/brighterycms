<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Module
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Module
 * @model Module
 * */
class Modules extends \Model {

    public $_table = 'modules';
    public $_fields = [
        'module_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 100],
        'code' => ['varchar', 400],
        'STATUS' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
            ],
        ];
    }

    public function fields() {
        return [
            'value' => 'value',
            'default_value' => 'default_value',
            'required' => 'required',
        ];
    }

}
