<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resumes Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resumes extends \Model {

    public $_table = 'resumes';
    public $_fields = [
        'resume_id' => ['int', 11, 'PRI'],
        'language_id' => ['varchar', 3],
        'user_id' => ['int', 11],
        'date_of_birth' => ['date'],
        'nationality_id' => ['int', 20],
        'marital_status_id' => ['int', 30],
        'created' => ['datetime'],
    ];

    public function rules() {
        return [
            'all' => [
                'date_of_birth' => ['required'],
                'nationality_id' => ['required', 'numeric'],
                'marital_status_id' => ['required', 'numeric'],
            ],
        ];
    }

    public function fields() {
        return [
            'language_id' => 'language_id',
            'user_id' => 'user_id',
            'date_of_birth' => 'date_of_birth',
            'nationality_id' => 'nationality_id',
            'marital_status_id' => 'marital_status_id',
            'created' => 'created',
        ];
    }

}
