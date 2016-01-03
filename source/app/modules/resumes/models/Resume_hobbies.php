<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resume Hobbies Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resume_hobbies extends \Model {

    public $_table = 'resume_hobbies';
    public $_fields = [
        'resume_hooby_id' => ['int', 11, 'PRI'],
        'resume_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'name' => ['varchar', 300],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'resume_id' => 'resume_id',
            'language_id' => 'language_id',
            'name' => 'name',
            'sort' => 'sort',
        ];
    }

}
