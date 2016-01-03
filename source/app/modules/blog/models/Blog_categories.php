<?php

namespace modules\blog\models;

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Blog Categories Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Blog_categories extends \Model {

    public $_table = 'blog_categories';
    public $_fields = [
        'blog_category_id' => ['int', 11, 'PRI'],
        'title' => ['varchar', 255],
        'seo' => ['varchar', 255, 'UNI'],
        'language_id' => ['varchar', 3],
        'image' => ['text'],
        'parent' => ['int', 11],
        'description' => ['text'],
        'sort' => ['int', 11],
        'created' => ['datetime'],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
                'parent' => ['required'],
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
            'image' => 'Image',
            'description' => 'Description',
            'sort' => 'Sort',
            'created' => 'Created',
            'seo' => 'SEO',
            'parent' => 'Parent',
        ];
    }

    public function getSubCategories($id) {
        return $this->Database->query("SELECT `blog_categories`.*"
                        . "FROM `blog_categories` "
                        . "WHERE blog_categories.parent='$id'")->result();
    }

}
