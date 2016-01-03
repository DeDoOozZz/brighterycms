<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resume contacts Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resume_contacts extends \Model {

    public $_table = 'resume_contacts';
    public $_fields = [
        'resume_contact_id' => ['int', 11, 'PRI'],
        'resume_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'contact_method' => ['varchar', 100],
        'contact_detail' => ['varchar', 200],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'contact_method' => ['required'],
                'contact_detail' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'resume_id' => 'resume_id',
            'language_id' => 'language_id',
            'contact_method' => 'contact_method',
            'contact_detail' => 'contact_detail',
            'sort' => 'sort',
        ];
    }

}
