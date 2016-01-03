<?php namespace modules\blog\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Blog Post Comments Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Blog_post_comments extends \Model {

    public $_table = 'blog_post_comments';
    public $_fields = [
        'blog_post_comment_id' => ['int', 11, 'PRI'],
        'blog_post_id' => ['int', 11],
        'name' => ['varchar', 255],
        'user_id' => ['int', 11],
        'datetime' => ['datetime'],
        'comment' => ['text'],
        'email' => ['varchar', 255],
    ];

    public function rules() {
        return [
            'unregisted' => [
                'name' => ['required'],
                'comment' => ['required'],
                'email' => ['email'],
            ],
            'registered' => [
                'comment' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'name' => 'Name',
            'datetime' => 'Datetime',
            'comment' => 'Commet',
            'email' => 'Email',
        ];
    }

}
