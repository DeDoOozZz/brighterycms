<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * @package Brightery CMS
 * @author
 * @version 1.0
 * @module Pm_history
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/Pm_history
 * @model Settings
 **/
class  Pm_history extends \Model
{
    public $_table = 'pm_history';
    public $_fields = [
        'pm_history_id' => ['int', 11, 'PRI'],
        'pm_issue_id' => ['int', 11],
        'actions' => ['enum', ['assign', 'forward', 'start', 'pause', 'done']],
        'from_user_id' => ['int', 11],
        'to_user_id' => ['int', 11],
        'datetime' => ['datetime'],
    ];


    public function rules()
    {
        return [
            'all' => [
                'actions' => ['required'],

            ],

        ];


    }


    public function fields()
    {
        return [
            'pm_issue_id' => 'pm issue id',
            'actions' => 'actions',
            'from_user_id' => 'from user id',
            'to_user_id' => 'to user id',
        ];
    }

    public function takenTime ($id = false){
        $this->layout = 'ajax';
        $userInfo = $this->permissions->getUserInformation();
        $actions =$this->database->query ( "SELECT * FROM `pm_history` WHERE
                    `pm_issue_id` = $id AND
                    `from_user_id` = $userInfo->user_id AND
                     pm_history_id > (SELECT pm_history_id FROM `pm_history` WHERE `pm_issue_id` = $id
                     AND `from_user_id` = $userInfo->user_id
                     AND `actions` = 'done' ORDER BY `datetime` DESC)
                     ORDER BY `datetime` ASC")->result();
        $startTime = null;
        $endTime = null;
        $total = 0;
        $i = 0;
        foreach( $actions as $value) {
            if ($value->actions == 'start'){
                if(count($actions) == $i){
                    $startTime = strtotime($value->datetime);
                    $total += (time() - $startTime);


                } else
                    $startTime = strtotime($value->datetime);


            }
            if ($value->actions == 'pause' || $value->actions == 'done' ){
                $endTime = strtotime($value->datetime);
                $total += ($endTime - $startTime);
            }

            $i++;
        }

        return $total;
    }

} 


