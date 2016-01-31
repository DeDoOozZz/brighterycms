<?php namespace modules\users\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Users Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 * @version 1.0
 * */
class Users extends \Model {

    public $_table = 'users';
    public $_fields = [
        'user_id' => ['int', 11, 'PRI'],
        'fullname' => ['varchar', 255],
        'email' => ['varchar', 'email', 255],
        'password' => ['varchar', 32],
        'image' => ['text'],
        'usergroup_id' => ['int', 11],
        'joindate' => ['datetime'],
        'google_id' => ['varchar', 300],
        'facebook_id' => ['varchar', 300],
        'facebook_access_token' => ['text'],
        'status' => ['enum', ['pending', 'active', 'banned']],
        'gender' => ['enum', ['female', 'male']],
        'birthdate' => ['datetime']
    ];

    public function rules() {
        return [
            'all' => [
            ],
            'add' => [
                'fullname' => ['required'],
                'phone' => ['required', 'numeric'],
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/users",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'required' => TRUE
                        ]
                    ]],
                'email' => ['required', 'email'],
                'password' => ['required'],
             'gender' => ['required']
            ],
            'edit' => [
                'fullname' => ['required'],
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/users/",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'required' => FALSE
                        ]
                    ]],
                'phone' => ['required', 'numeric'],
                'email' => ['required', 'email'],
                'gender' => ['required']
            ],
            'login' => [
                'username' => ['required'],
                'password' => ['required', 'checkPasswordValidity'],
            ],
            'register' => [
                'fullname' => ['required'],
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/users/",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'required' => TRUE
                        ]
                    ]],
                'email' => ['required', 'email', 'unique' => ['users', 'email']],
                'password' => ['required'],
                'confirm_password' => ['required', 'matches' =>['password']],
                'gender' => ['required']
            ],
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
            'confirm_password' => 'Confirm Password',
            'phone' => 'Phone',
        ];
    }

    public function _checkPasswordValidity($str) {
        $this->Validation->setValidationMessage(__FUNCTION__, $this->Language->phrase('checkPasswordValidity'));
        if ($this->Permissions->checkUserCredentials(trim($this->Input->post('username')), md5($this->Input->post('password'))))
            return true;
        return false;
    }

}
