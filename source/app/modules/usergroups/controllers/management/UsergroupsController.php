<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Usergroups
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module usergroups
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/usergroups
 * @controller UsergroupsController
 *
 * */
class UsergroupsController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('usergroups');
    }

    public function indexAction() {
        $this->permission('index');
        $modules = [];
        $model = new \modules\usergroups\models\Usergroups();
        $model->_select = "usergroup_id, name";
        return $this->render('usergroups/index', [
                    'items' => $model->get()
        ]);
    }

    public function manageAction($id = false){
        $this->permission('manage');
        $model = new \modules\usergroups\models\Usergroups('management');
        $model->attributes = $this->input->post();
        $permissions_management = $this->config->get('Permissions.management');
        $permissions_frontend = $this->config->get('Permissions.frontend');

        $modules_user_zone = new \modules\usergroups\models\Usergroup_zones(FALSE);
        $module_checked = new \modules\usergroups\models\Usergroup_zones();
        $module_checked->_select = "permission , usergroup_zone_id , usergroup_id , module";
        $module_checked->usergroup_id = $id;


        if ($id){
            $model->usergroup_id = $id;
            foreach ($model as $row) {

                $selected_permissions[$row->module][] = $row->permission;
            }
        }

        $model->language_id = $this->language->getDefaultLanguage();


        if (!$id)
            $model->created = date("Y-m-d H:i:s");

        if ($id = $model->save()) {
            $modules_user_zone->usergroup_id = "$id";
            $modules_user_zone->delete();
            foreach ($this->input->post('checkbox') as $key => $value) {
                $array = explode('-', $value);
                $q['permission'] = $array[0];
                $q['module'] = $array[1];
                $q['usergroup_id'] = $id;
                $modules_user_zone->attributes = $q;
                $modules_user_zone->save();
            }

            Uri_helper::redirect("management/usergroups");
        } else
            return $this->render('usergroups/manage', [
                        'item' => $id ? $model->get() : null,
                        'per_management' => $permissions_management,
                        'per_frontend' => $permissions_frontend,
                        'checked' => $module_checked->get()
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\usergroups\models\Usergroups();
        $model_user_group = new \modules\usergroups\models\Usergroup_zones();
        $model->usergroup_id = $id;
        $model_user_group->usergroup_id = $id;
        if ($model_user_group->delete() && $model->delete())
            Uri_helper::redirect("management/usergroups");
    }

}

//IPADDR=104.236.247.47
//NETMASK=255.255.192.0
//GATEWAY=104.236.192.1