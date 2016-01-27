<?php namespace modules\links\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Links Model
 * @package Brightery CMS
 * @author
 * @version 1.0
 * */
class Links extends \Model {

    public $_table = 'links';
    public $_fields = [
        'link_id' => ['int', 11, 'PRI'],
        'link_type_id' => ['int', 11],
        'name' => ['varchar', 200],
        'url' => ['text'],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
                'url' => ['required'],
//                'sort' => ['required', 'numeric'],
            ],
        ];
    }

    public function fields() {
        return [
            'link_type_id' => 'link_type_id',
            'name' => 'name',
            'url' => 'url',
            'sort' => 'sort',
        ];
    }

}
