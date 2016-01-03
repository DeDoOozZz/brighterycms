<?php namespace modules\sliders\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * slides Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Slides extends \Model {

    public $_table = 'slides';
    public $_fields = [
        'slide_id' => ['int', 11, 'PRI'],
        'title' => ['varchar', 255],
        'image' => ['text'],
        'caption' => ['text'],
        'url' => ['text'],
        'from_date' => ['datetime'],
        'to_date' => ['datetime'],
        'created' => ['datetime'],
        'sort' => ['int', 11],
        'slider_id' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
            ],
            'add' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/sliders/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                    ]],
            ],
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/sliders/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                    ]],
            ]
        ];
    }

    public function fields() {
        return [
            'title' => 'Title',
            'image' => 'Image',
            'caption' => 'Caption',
            'url' => 'URL',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'created' => 'Created',
            'sort' => 'Sort',
            'slider_id' => 'Sort',
        ];
    }

}
