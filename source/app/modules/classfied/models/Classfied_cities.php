<?php

namespace modules\classfied\models;

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Cities Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Classfied_cities extends \Model {

    public $_table = 'classfied_cities';
    public $_fields = [
        'classfied_city_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 50],
        'classfied_country_id' => ['int'],
        
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
            'name' => 'name',
            'classfied_country_id' => 'classfied_country_id',
        ];
    }

}
