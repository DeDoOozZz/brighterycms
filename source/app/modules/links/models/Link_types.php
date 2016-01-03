<?php namespace modules\links\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Link Types Model
 * @package Brightery CMS
 * @author
 * @version 1.0
 * */
class Link_types extends \Model {

    public $_table = 'link_types';
    public $_fields = [
        'link_type_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 200],
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
