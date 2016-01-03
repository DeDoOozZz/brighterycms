<?php namespace modules\clinic\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * @package Brightery CMS
 * @author
 * @version 1.0
 * @module Clinic_specification_branches
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/clinic
 **/
class Clinic_specification_branches extends \Model
{
    public $_table = 'clinic_specification_branches';
    public $_fields = array(
        'clinic_specification_branch_id' => array('int', 11, 'PRI'),
        'clinic_specification_id' => array('int', 11),
        'clinic_branch_id' => array('int', 11),
    );

    public function rules()
    {
        return [
            'all' => [
                'clinic_specification_id' => ['required', 'numeric'],
                'clinic_branch_id' => ['required', 'numeric'],
            ],
        ];
    }

    public function fields()
    {
        return array(
            'clinic_specification_id' => 'clinic specification id',
            'clinic_branch_id' => 'clinic branch id',
        );
    }
} 
 