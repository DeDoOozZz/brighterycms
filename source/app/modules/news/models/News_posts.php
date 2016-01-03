<?php namespace modules\news\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * News Posts Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 **/
class News_posts extends \Model
{
    public $_table = 'news_posts';
    public $_fields = [
        'news_post_id' => ['int', 11, 'PRI'],
        'news_category_id' => ['int', 11],
        'title' => ['varchar', 200],
        'content' => ['text'],
        'image' => ['text'],
    ];

    public function rules()
    {
        return [
            'all' => [
                'title' => ['required'],
                'content' => ['required'],
                'news_category_id' => ['required'],
                'image' => ['required'],
            ]];
    }

    public function fields()
    {
        return [
            'title' => 'Title',
            'news_category_id' => 'Category',
            'content' => 'Content',
            'image' => 'Image',
        ];
    }
}
