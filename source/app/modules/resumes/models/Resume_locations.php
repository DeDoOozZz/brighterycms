<?php namespace modules\resumes\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Resume Locations Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Resume_locations extends \Model {

    public $_table = 'resume_locations';
    public $_fields = [
        'resume_location_id' => ['int', 11, 'PRI'],
        'resume_id' => ['int', 11],
        'language_id' => ['varchar', 3],
        'location' => ['varchar', 500],
        'lat' => ['varchar', 30],
        'long' => ['varchar', 30],
        'address' => ['text'],
        'sort' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'location' => ['required'],
                'lat' => ['required'],
                'long' => ['required'],
                'address' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'resume_id' => 'resume_id',
            'language_id' => 'language_id',
            'location' => 'location',
            'lat' => 'lat',
            'long' => 'long',
            'address' => 'address',
            'sort' => 'sort',
        ];
    }

}
