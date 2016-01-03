<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * Comments ..
 *
 * @package Brightery CMS
 * @author
 * @version 1.0
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pm
 * @model Pm_comments
 **/
class  Pm_comments extends \Model
{
    public $_table = 'pm_comments';
    public $_fields = [
        'pm_comment_id' => ['int', 11, 'PRI'],
        'pm_issue_id' => ['int', 11],
        'user_id' => ['int', 11],
        'comment' => ['longtext'],
        'time' => ['datetime'],
        'parent' => ['longtext'],
    ];


    public function rules()
    {
        return [
            'all' => [
//                'pm_issue_id' => ['required', 'numeric'],
//                'user_id' => ['required', 'numeric'],
//                'comment' => ['required'],
//                'time' => ['required'],
//                'parent' => ['required'],
            ],

            'add' => [
//                'comment' => ['required'],


            ]



        ];
    }


    public function fields()
    {
        return [
            'pm_issue_id' => 'pm issue id',
            'user_id' => 'user id',
            'comment' => 'comment',
            'time' => 'time',
            'parent' => 'parent',
        ];
    }

    public function replies ($comment_id){
        $comments = $this;
        $comments->parent = $comment_id;
        $comments->_select = "pm_comment_id,pm_issue_id,comment,time,parent,
            (SELECT users.fullname FROM users WHERE users.user_id = pm_comments.user_id) AS username,
            (SELECT users.image FROM users WHERE users.user_id = pm_comments.user_id) AS image";
        return $comments->get();
    }





}

 