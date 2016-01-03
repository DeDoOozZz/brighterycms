<?php namespace modules\downloads\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Downloads Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Downloads extends \Model {

    public $_table = 'downloads';
    public $_fields = [
        'download_id' => ['int', 11, 'PRI'],
        'language_id' => ['varchar', 3],
        'url' => ['text'],
        'image' => ['text'],
        'created' => ['datetime'],
    ];

    public function rules() {
        return [
            'all' => [
                'url' => ['required'],
                'image' => ['required'],
            ], 'add' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/downloads",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                    ]],
            ]
            ,
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/downloads",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                    ]],
            ]
        ];
    }

    public function fields() {
        return [
            'language_id' => 'language id',
            'url' => 'url',
            'image' => 'image',
            'created' => 'created',
        ];
    }

}
