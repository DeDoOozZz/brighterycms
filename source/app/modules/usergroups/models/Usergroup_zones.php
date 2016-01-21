<?php namespace modules\usergroups\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Usergroup Zones Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Usergroup_zones extends \Model {

    public $_table = 'usergroup_zones';
    public $_fields = [
        'usergroup_zone_id' => ['int', 11, 'PRI'],
        'usergroup_id' => ['int', 11],
        'module' => ['varchar', 100],
        'permission' => ['varchar', 100],
    ];

    public function rules() {
        return [
            'all' => [
// 	 'usergroup_id' =>['required', 'numeric'], 
// 	 'module_id' =>['required', 'numeric'], 
// 	 'permission' =>['required'], 
            ],
        ];
    }

    public function fields() {
        return [
            'usergroup_id' => 'usergroup id',
            'module' => 'module',
            'permission' => 'permission',
        ];
    }

}
