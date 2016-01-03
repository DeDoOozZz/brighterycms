<?php namespace modules\usergroups\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Zones Model
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * */
class Zones extends \Model {

    public $_table = 'zones';
    public $_fields = [
        'zone_id' => ['int', 11, 'PRI'],
        'module_id' => ['int', 11],
        'permission' => ['varchar', 50],
        'name' => ['varchar', 100],
        'var_view' => ['varchar', 100, 'UNI'],
        'var_add' => ['varchar', 100],
        'var_edit' => ['varchar', 100],
        'var_delete' => ['varchar', 100],
        'var_print' => ['varchar', 100],
        'desc' => ['text'],
        'order' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'module_id' => ['required', 'numeric'],
                'permission' => ['required'],
                'name' => ['required'],
                'var_view' => ['required'],
                'var_add' => ['required'],
                'var_edit' => ['required'],
                'var_delete' => ['required'],
                'var_print' => ['required'],
                'desc' => ['required'],
                'order' => ['required', 'numeric'],
            ],
        ];
    }

    public function fields() {
        return [
            'module_id' => 'module_id',
            'permission' => 'permission',
            'name' => 'name',
            'var_view' => 'var_view',
            'var_add' => 'var_add',
            'var_edit' => 'var_edit',
            'var_delete' => 'var_delete',
            'var_print' => 'var_print',
            'desc' => 'desc',
            'order' => 'order',
        ];
    }

}
