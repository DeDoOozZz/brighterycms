<?php namespace modules\sliders\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * sliders Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Sliders extends \Model {

    public $_table = 'sliders';
    public $_fields = [
        'slider_id' => ['int', 11, 'PRI'],
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
