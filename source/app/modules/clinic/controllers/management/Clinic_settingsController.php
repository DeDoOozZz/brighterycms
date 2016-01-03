<?php

defined('ROOT') OR exit('No direct script access allowed');
/**
 * Settings Controller
 * @package Brightery CMS
 * @author 
 * @version 1.0

 * @interface management
 * @module Settings
 * @category general
 * @module_version  1.0

 * @link http://store.brightery.com/module/general/Settings
 * @controller Settings
 * */
class Clinic_settingsController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;
    

    public function indexAction() {
        $this->permission('index');
        $this->language->load("Clinic_settings");
        $model = new \modules\clinic\models\Modules();
        $model->name="Modules";
        $model->name = 'clinic';
        $model->_select = "`module_id`";
        $items = $model->get();
        $id=$items[0]->module_id;
        $model_settings= new \modules\clinic\models\Modules_setting();
       
        $model_settings->module_id=$id;
        $model_settings->_select = "`key`,`value`,`default_value`";
       $items_settings= $model_settings->get();
        foreach ($items_settings as $item) {
            $arr[$item->key] = $item->value;
        }
        if (REQUEST_METHOD == 'POST')
        {
           
            foreach ($_POST as $key=>$value)
            {
                 $model_settings->key="$key";
                 $model_settings->value="$value";
                $model_settings->save();
               
            }
        }
        
        return $this->render('clinic_settings/index', [
                    'item' => $arr
        ]);
        
       
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $this->language->load("settings");
        $model = new \modules\settings\models\Settings();
        $model->language_id = $this->language->getDefaultLanguage();
        if ($id) {
            $model->key = $id;
            if (!$model->get())
                Brightery::error404();
        }
        else {
            
        }
        if (REQUEST_METHOD == 'POST')
            $model->attributes = [
                'value' => $this->input->post('value'),
                'default_value' => $this->input->post('default_value'),
                'required' => $this->input->post('required'),
            ];

        if ($model->save()) {
            Uri_helper::redirect("management/settings");
        }
        return $this->render('settings/manage', [
                   'item' => $id ? $model->get() : null
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
           return Brightery::error404();
        }
        $model = new \modules\settings\models\Settings();
        $model->key = $id;
        if ($model->delete())
            Uri_helper::redirect("management/settings");
    }

}
