<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resume Activity Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resume_activities extends \Model {

    public $_table = 'resume_activities';
    public $_fields = [
        'resume_activity_id' => ['int', 11, 'PRI'],
        'resume_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'activity' => ['varchar', 300],
        'role' => ['varchar', 200],
        'from' => ['date'],
        'to' => ['date'],
        'desc' => ['text'],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'activity' => ['required'],
                'role' => ['required'],
                'from' => ['required'],
                'to' => ['required'],
                'desc' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'resume_id' => 'resume_id',
            'language_id' => 'language_id',
            'activity' => 'activity',
            'role' => 'role',
            'from' => 'from',
            'to' => 'to',
            'desc' => 'desc',
            'sort' => 'sort',
        ];
    }

}
