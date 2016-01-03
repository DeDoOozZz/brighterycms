<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resume language Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resume_languages extends \Model {

    public $_table = 'resume_languages';
    public $_fields = [
        'resume_language_id' => ['int', 11, 'PRI'],
        'resume_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'name' => ['varchar', 100],
        'level' => ['varchar', 100],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
                'level' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'resume_id' => 'resume_id',
            'language_id' => 'language_id',
            'name' => 'name',
            'level' => 'level',
            'sort' => 'sort',
        ];
    }

}
