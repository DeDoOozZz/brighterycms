<?php namespace modules\classfied\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Classfied Experience Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Classfied_experience extends \Model {

    public $_table = 'classfied_experience';
    public $_fields = [
        'classfied_experience_id' => ['int', 11, 'PRI'],
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
