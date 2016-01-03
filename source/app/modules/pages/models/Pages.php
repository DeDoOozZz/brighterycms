<?php namespace modules\pages\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Pages Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Pages extends \Model {

    public $_table = 'pages';
    public $_fields = [
        'page_id' => ['int', 11, 'PRI'],
        'language_id' => ['varchar', 3],
        'title' => ['varchar', 300],
        'seo' => ['varchar', 150, 'UNI'],
        'content' => ['longtext'],
        'created' => ['datetime'],
        'visibility_status_id' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
                'seo' => ['required'],
                'content' => ['required'],
                'visibility_status_id' => ['required', 'numeric', 'dropdown' => [array_keys($this->attributes['visibility_status_menu'])]],
            ],
//            'add' => [
//                'title' => ['required'],
//                'seo' => ['required'],
//                'content' => ['required'],
//            ],
//            'edit' => [
//                'title' => ['required'],
//                'seo' => ['required'],
//                'content' => ['required'],
//            ],
        ];
    }

    public function fields() {
        return [
            'language_id' => 'language_id',
            'title' => 'Title',
            'seo' => 'SEO',
            'content' => 'Content',
            'created' => 'Created',
            'visibility_status_id' => 'Visibilty',
        ];
    }

}
