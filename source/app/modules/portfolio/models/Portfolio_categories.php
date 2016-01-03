<?php namespace modules\portfolio\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Portfolio Categories Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Portfolio_categories extends \Model {

    public $_table = 'portfolio_categories';
    public $_fields = [
        'portfolio_category_id' => ['int', 11, 'PRI'],
        'language_id' => ['varchar', 3],
        'title' => ['varchar', 300],
        'seo' => ['varchar', 300],
        'description' => ['text'],
        'created' => ['datetime'],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
                'seo' => ['required'],
                'description' => ['required'],
            ],
            
            ];
    }

    public function fields() {
        return [
            'language_id' => 'language id',
            'title' => 'title',
            'seo' => 'seo',
            'description' => 'description',
            'created' => 'created',
        ];
    }

}
