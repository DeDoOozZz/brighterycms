<?php namespace modules\portfolio\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Portfolio Model
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * */
class Portfolio extends \Model {

    public $_table = 'portfolio';
    public $_fields = [
        'portfolio_id' => ['int', 11, 'PRI'],
        'portfolio_category_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'title' => ['varchar', 300],
        'seo' => ['varchar', 300, 'UNI'],
        'image' => ['text'],
        'description' => ['text'],
        'created' => ['datetime'],
    ];

    public function rules() {
        return [
            'all' => [
                'portfolio_category_id' => ['required', 'numeric'],
                'title' => ['required'],
                'seo' => ['required'],
                'image' => ['required'],
                'description' => ['required'],
            ], 'add' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/portfolio",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                ]],
            ]
            ,
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/portfolio",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                ]],
            ]];
    }

    public function fields() {
        return [
            'portfolio_category_id' => 'portfolio category id',
            'language_id' => 'language id',
            'title' => 'title',
            'seo' => 'seo',
            'image' => 'image',
            'description' => 'description',
            'created' => 'created',
        ];
    }

}
