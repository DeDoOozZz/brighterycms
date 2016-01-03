<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resume Skills Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resume_skills extends \Model {

    public $_table = 'resume_skills';
    public $_fields = [
        'resume_skill_id' => ['int', 11, 'PRI'],
        'resume_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'category' => ['varchar', 300],
        'content' => ['text'],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'category' => ['required'],
                'content' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'resume_id' => 'resume_id',
            'language_id' => 'language_id',
            'category' => 'category',
            'content' => 'content',
            'sort' => 'sort',
        ];
    }

}
