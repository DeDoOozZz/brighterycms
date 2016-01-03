<?php namespace modules\contactus\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Contact Us Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Contactus extends \Model {

    public $_table = 'contactus';
    public $_fields = [
        'message_id' => ['int', 11, 'PRI'],
        'user_id' => ['int', 11],
        'name' => ['varchar', 255],
        'email' => ['text'],
        'message' => ['text'],
        'created' => ['datetime'],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
               'email' => ['required','email'],
                'message' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'message' => 'Message',
            'created' => 'Created',
        ];
    }

}
