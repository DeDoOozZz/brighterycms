<?php namespace modules\classfied\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Classfied Types Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Classfied_types extends \Model {

    public $_table = 'classfied_types';
    public $_fields = [
        'classfied_type_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 16],
        'var_name' => ['varchar', 32],
        'color' => ['varchar', 20],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
                'var_name' => ['required'],
                'color' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'name' => 'name',
            'var_name' => 'var_name',
            'color' => 'Color',
        ];
    }

}
