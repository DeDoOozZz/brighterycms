<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resume Work History Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resume_work_history extends \Model {

    public $_table = 'resume_work_history';
    public $_fields = [
        'resume_work_history_id' => ['int', 11, 'PRI'],
        'resume_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'company' => ['varchar', 300],
        'from' => ['date'],
        'to' => ['date'],
        'category' => ['varchar', 300],
        'title' => ['varchar', 300],
        'nationality_id' => ['varchar', 20],
        'responsbilities' => ['text'],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'company' => ['required'],
                'from' => ['required'],
                'to' => ['required'],
                'category' => ['required'],
                'title' => ['required'],
                'nationality_id' => ['required'],
                'responsbilities' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'resume_id' => 'resume_id',
            'language_id' => 'language_id',
            'company' => 'company',
            'from' => 'from',
            'to' => 'to',
            'category' => 'category',
            'title' => 'title',
            'nationality_id' => 'nationality',
            'responsbilities' => 'responsbilities',
            'sort' => 'sort',
        ];
    }

}
