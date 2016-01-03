<?php namespace modules\notifications\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * Categories Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 **/
class Notifications extends \Model
{
    public $_table = 'notifications';
    public $_fields = [
        'notification_id' => ['int', 11, 'PRI'],
        'user_id' => ['int', 11],
        'content' => ['text'],
        'link' => ['text'],
        'created' => ['datetime'],
        'status' => ['enum', ['unread', 'read']],
    ];


    public function rules()
    {
        return [
            'all' => [
                'user_id' => ['required', 'numeric'],
                'content' => ['required'],
                'link' => ['required'],
                'status' => ['required'],
            ],];


    }


    public function fields()
    {
        return [
            'user_id' => 'user id',
            'content' => 'content',
            'link' => 'link',
            'created' => 'created',
            'status' => 'status',
        ];
    }
}
