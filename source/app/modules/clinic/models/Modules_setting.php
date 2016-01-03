<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @module Module_setting
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Module_setting
 * @model Module_setting
 * */
class Modules_setting extends \Model {

    public $_table = 'module_settings';
    public $_fields = [
        'module_setting_id' => ['int', 11, 'PRI'],
        'module_id' => ['int', 11],
        'KEY' => ['varchar', 50, 'UNIQUE'],
        'value' => ['text'],
        'default_value' => ['text'],
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
