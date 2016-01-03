<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resume Education Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resume_education extends \Model {

    public $_table = 'resume_education';
    public $_fields = [
        'resume_education_id' => ['int', 11, 'PRI'],
        'resume_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'degree' => ['varchar', 100],
        'field' => ['varchar', 100],
        'school' => ['varchar', 100],
        'grade' => ['varchar', 100],
        'from_year' => ['int', 11],
        'from_month' => ['int', 11],
        'to_year' => ['int', 11],
        'to_month' => ['int', 11],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'degree' => ['required'],
                'field' => ['required'],
                'school' => ['required'],
                'grade' => ['required'],
                'from-year' => ['required', 'numeric'],
                'from-month' => ['required', 'numeric'],
                'to-year' => ['required', 'numeric'],
                'to-month' => ['required', 'numeric'],
            ],
        ];
    }

    public function fields() {
        return [
            'resume_id' => 'resume_id',
            'language_id' => 'language_id',
            'degree' => 'degree',
            'field' => 'field',
            'school' => 'school',
            'grade' => 'grade',
            'from_year' => 'from_year',
            'from_month' => 'from_month',
            'to_year' => 'to_year',
            'to_month' => 'to_month',
            'sort' => 'sort',
        ];
    }

}
