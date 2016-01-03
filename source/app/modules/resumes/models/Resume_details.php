<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resume Details Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resume_details extends \Model {

    public $_table = 'resume_details';
    public $_fields = [
        'resume_detail_id' => ['int', 11, 'PRI'],
        'resume_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'full_name' => ['varchar', 200],
        'seo' => ['varchar', 200],
    ];

    public function rules() {
        return [
            'all' => [
                'resume_id' => ['required', 'numeric'],
                'language_id' => ['required'],
                'full_name' => ['required'],
                'seo' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'resume_id' => 'resume_id',
            'language_id' => 'language_id',
            'full_name' => 'full_name',
            'seo' => 'seo',
        ];
    }

}
