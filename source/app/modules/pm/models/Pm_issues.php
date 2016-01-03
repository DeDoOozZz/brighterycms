<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * @package Brightery CMS
 * @author
 * @version 1.0
 * @module Pm_issues
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/Pm_issues
 * @model Settings
 **/
class  Pm_issues extends \Model
{
    public $_table = 'pm_issues';
    public $_fields = [
        'pm_issue_id' => ['int', 11, 'PRI'],
        'title' => ['varchar', 200],
        'description' => ['longtext'],
        'pm_reviewer_id' => ['int', 11],
        'pm_project_id' => ['int', 11],
        'created_time' => ['datetime'],
        'estimated_time' => ['time'],
        'parent' => ['int', 11],
        'pm_priority_id' => ['int', 11],
        'deadline' => ['datetime'],
        'pm_issue_type_id' => ['int', 11],
        'pm_issue_statues_id' => ['int', 11],
    ];


    public function rules()
    {
        return [
            'add' => [

                'title' => ['required'],
                'description' => ['required'],
                'pm_issue_type_id' => ['required'],
                'pm_priority_id' => ['required'],
            ],
            'edit' => [

                'title' => ['required'],
                'description' => ['required'],
                'pm_issue_type_id' => ['required'],
                'pm_priority_id' => ['required'],
            ],
        ];
    }


    public function fields()
    {
        return [
            'title' => 'title',
            'description' => 'description',
            'pm_reviewer_id' => 'pm reviewer id',
            'pm_project_id' => 'pm project id',
            'created_time' => 'created time',
            'estimated_time' => 'estimated time',
            'parent' => 'parent',
            'pm_priority_id' => 'pm priority id',
            'deadline' => 'deadline',
            'pm_issue_type_id' => 'pm issue type id',
        ];
    }
    public function issue_statues ($issue_statues_id){

        $pm_issues = $this;
        $pm_issues->_select = "pm_issue_id, title, pm_issue_statues_id";
        $pm_issues -> pm_issue_statues_id = $issue_statues_id;
        return $pm_issues->get();


    }

    public function assignedIssues ($id = false){

        $assigned = $this->database->query ("SELECT *,
           (SELECT users.`fullname` FROM users WHERE users.user_id = pm_history.to_user_id) AS to_user
            FROM pm_history WHERE `pm_issue_id` = $id AND (actions = 'assign' OR actions = 'forward' ) ")->result();
        return $assigned;
    }
} 
 