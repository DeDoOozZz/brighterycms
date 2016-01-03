<?php namespace modules\blog\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Blog Posts Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */

class Blog_posts extends \Model {

    public $_table = 'blog_posts';
    public $_fields = [ 
        'blog_post_id' => ['int', 11, 'PRI'],
        'blog_category_id' => ['int', 11],
        'user_id' => ['int', 11],
        'title' => ['varchar', 255],
        'language_id' => ['varchar', 3],
        'seo' => ['varchar', 255, 'UNI'],
        'image' => ['text'],
        'short_content' => ['text'],
        'content' => ['text'],
        'created' => ['datetime'],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
                'content' => ['required'],
            ],
            'add' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/blog",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                ]
                ],

            ],
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/blog",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                ]
                ],

            ],
        ];
    }

    public function fields() {
        return [
            'title' => 'Title',
            'seo' => 'SEO',
            'image' => 'Image',
            'short_content' => 'Short Content',
            'content' => 'Content',
            'created' => 'Created',
        ];
    }

}
