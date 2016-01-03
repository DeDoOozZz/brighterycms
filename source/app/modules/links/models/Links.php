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
        'var' => ['text'],
        'visibility_status_id' => ['int', 11],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
                'url' => ['required'],
                'var' => ['required'],
                'visibility_status_id' => ['required', 'numeric'],
                'sort' => ['required', 'numeric'],
            ],
        ];
    }

    public function fields() {
        return [
            'link_type_id' => 'link_type_id',
            'name' => 'name',
            'url' => 'url',
            'var' => 'var',
            'visibility_status_id' => 'visibility_status_id',
            'sort' => 'sort',
        ];
    }

}
