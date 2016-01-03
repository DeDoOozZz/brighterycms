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
    ];

    public function rules() {
        return [
            'all' => [
                'client_name' => ['required'],
                'client_position' => ['required'],
                'message' => ['required'],
                'visibility_status_id' => ['required', 'numeric'],
            ],
        ];
    }

    public function fields() {
        return [
            'client_name' => 'Client Name',
            'client_position' => 'Client Position',
            'message' => 'Message',
            'visibility_status_id' => 'Visibility',
        ];
    }

}
