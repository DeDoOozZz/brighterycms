<?php
namespace modules\pm\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * @package Brightery CMS
 * @author
 * @version 1.0
 * @module Pm_attachments
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/Pm_attachments
 * @model Settings
 **/
class  Pm_attachments extends \Model
{
    public $_table = 'pm_attachments';
    public $_fields = [
        'pm_attachment_id' => ['int', 11, 'PRI'],
        'file_name' => ['text'],
        'count' => ['int', 11],
        'attachment_type' => ['enum', ['issue', 'comment']],
        'uploaded_time' => ['datetime'],
        'type' => ['varchar', 255],
        'pm_issue_id' => ['int', 11],
    ];


    public function rules()
    {
        return [

            'all' => [],

            'add' => [
                'file_name' => ['file' => [[


                    'upload_path' => "./cdn/pm_attachments/",
                    'required' => TRUE

                ]]],
            ],

            'edit' => [
                'file_name' => ['file' => [[

                    'upload_path' => "./cdn/pm_attachments/",
                    'required' => FALSE

                ]]],
            ],
        ];
    }


    public function fields()
    {
        return [
            'file_name' => 'file name',
            'count' => 'count',
            'attachment_type' => 'attachment type',
            'uploaded_time' => 'uploaded time',
            'type' => 'type',
            'pm_issue_id' => 'pm issue id',
        ];
    }
} 
 