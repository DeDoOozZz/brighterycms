<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Modules Controller
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module store
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/modules
 * @controller Modules
 *
 * */
class ModulesController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->language->load("modules");
        $model = new \modules\store\models\Modules();
        $model->_select = "module_id, name, raw_name, status";
        $this->load->library('pagination');
        $model->_offset = $offset;
        $model->_limit = $this->config->get('limit');
        $config = [
            'url' => Uri_helper::url('management/blog_categories/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('modules/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

//     public function storeAction(){
//         $this->permission('store');
//         $this->language->load("modules");
//         $model = new Modules();
//         $model->_select = "module_id, name, code, status";
//        return $this->render('modules_store/index', [
//            'items' => $model->get(),
//        ]);
//       
//         
//    }
}
