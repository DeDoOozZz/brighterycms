<?php namespace modules\testimonials\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Testimonials Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Testimonials extends \Model {

    public $_table = 'testimonials';
    public $_fields = [
        'testimonial_id' => ['int', 11, 'PRI'],
        'client_name' => ['varchar', 200],
        'client_position' => ['varchar', 200],
        'message' => ['text'],
        'visibility_status_id' => ['int', 1],
        'image' => ['varchar', 150],
    ];

    public function rules() {
        return [
            'all' => [
                'client_name' => ['required'],
                'client_position' => ['required'],
                'message' => ['required'],
                'visibility_status_id' => ['required', 'numeric'],
            ],
             'add' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/testimonials/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                    ]],
            ],
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/testimonials/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                    ]],
            ]
        ];
    }

    public function fields() {
        return [
            'client_name' => 'Client Name',
            'client_position' => 'Client Position',
            'message' => 'Message',
            'visibility_status_id' => 'Visibility',
            'image' => 'Image',
        ];
    }

}
