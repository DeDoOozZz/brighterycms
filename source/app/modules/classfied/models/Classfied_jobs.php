<?php namespace modules\classfied\models;

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Jobs Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Classfied_jobs extends \Model {

    public $_table = 'classfied_jobs';
    public $_fields = [
        'classfied_job_id' => ['int', 10, 'PRI'],
        'classfied_type_id' => ['int', 11],
        'classfied_category_id' => ['int', 11],
        'title' => ['varchar', 100],
        'description' => ['text'],
        'company' => ['varchar', 150],
        'classfied_city_id' => ['int', 11],
        'classfied_area_id' => ['int', 11],
        'classfied_country_id' => ['int', 11],
        'url' => ['varchar', 150],
        'created_on' => ['date'],
        'is_temp' => ['tinyint', 4],
        'is_active' => ['tinyint', 4],
        'views_count' => ['tinyint', 11],
        'auth' => ['varchar', 32],
        'poster_email' => ['varchar', 100],
        'apply_online' => ['tinyint', 4],
        'spotlight' => ['tinyint', 4],
        'workplace' => ['varchar', 150],
        'salary_from' => ['int', 11],
        'salary_to' => ['int', 11],
        'is_hidden_num' => ['tinyint', 2],
        'phone_num' => ['varchar', 30],
        'classfied_experience_id' => ['int', 11 ],
        'classfied_currency_id' => ['int', 11],
    ];

    public function rules() {
//        return [
//            'all' => [
//                'classfied_type_id' => ['required'],
//                'classfied_category_id' => ['required', 'numeric'],
//                'title' => ['required'],
//                'description' => ['required'],
//                'company' => ['required'],
//            ],
//        ];
    }

    public function fields() {
        return [
            'classfied_type_id' => 'classfied_type_id',
            'classfied_category_id' => 'classfied_category_id',
            'title' => 'title',
            'description' => 'description',
            'workplace' => 'workplace',
            'company' => 'company',
        ];
    }

}
