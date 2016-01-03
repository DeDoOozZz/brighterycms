<?php namespace modules\users\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Sessions Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 * @version 1.0
 * */
class Sessions extends \Model {

    public $_table = 'sessions';
    public $_fields = [
        'session_id' => ['varchar', 11, 'PRI'],
        'user_id' => ['int', 11],
        'ip' => ['varchar', 255],
        'latest_activity' => ['datetime'],
        'agent' => ['varchar', 255]

    ];
/*
 * CREATE TABLE `brighterycms`.`sessions`(
  `session_id` VARCHAR(60) NOT NULL,
  `user_id` INT,
  `ip` VARCHAR(32),
  `latest_activity` DATETIME,
  `agent` VARCHAR(255),
  `data` TEXT,
  PRIMARY KEY (`user_session_id`)
);

 */
    public function rules() {
        return [
            'all' => [
            ],
            'add' => [
                'fullname' => ['required'],

            ],
            'edit' => [
                'fullname' => ['required'],

            ]
        ];
    }

    public function fields() {
        return [
            'fullname' => 'Fullname',
            'email' => 'Email',
            'password' => 'Password',
            'image' => 'Image',
            'usergroup_id' => 'Usergroup',
            'status_id' => 'Status',
            'gender' => 'Gender',
        ];
    }


}
