<?php namespace modules\classfied\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Classfied Currencies Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Classfied_currencies extends \Model {

    public $_table = 'classfied_currencies';
    public $_fields = [
        'classfied_currency_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 16],
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
        ];
    }

}
