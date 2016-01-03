<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Modules_store Controller
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module store
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/modules
 * @controller Modules_store
 *
 **/

class Modules_storeController extends Brightery_Controller{
     protected $interface = 'management';
     protected $layout = 'default';
     protected $auth = true;
     
     public function indexAction(){
         $this->permission('index');
         $this->language->load("modules");
         $model = new \modules\store\models\Modules();
//         $model->_select = "module_id, name, code, status";
        return $this->render('modules_store/index', [
            'items' => $model->get(),
        ]);
    }
     public function single_moduleAction(){
         $this->permission('index');
         $this->language->load("modules");
         $model = new \modules\store\models\Modules();
         $model->_select = "module_id, name, code, status";
        return $this->render('modules_store/single_module', [
            'items' => $model->get(),
        ]);
    }
}