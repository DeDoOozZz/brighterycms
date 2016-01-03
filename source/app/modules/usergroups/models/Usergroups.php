<?php namespace modules\usergroups\models;
defined('ROOT') OR exit('No direct script access allowed');
/**
 * Usergroups Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Usergroups extends \Model {

    public $_table = 'usergroups';
    public $_fields = [
        'usergroup_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 255],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'name' => 'Name',
        ];
    }

}
