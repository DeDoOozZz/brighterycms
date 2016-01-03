<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pm_priorities Controller
 * @package Brightery CMS
 * @author 
 * @version 1.0

 * @interface management
 * @module pm
 * @category general
 * @module_version  1.0

 * @link http://store.brightery.com/module/general/Pm_priorities
 * @controller Pm_priorities
 * */
class Pm_prioritiesController extends Brightery_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->language->load("pm_priorities");

    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $model = new \modules\pm\models\Pm_priorities();
        $model->_select = "pm_priority_id,name,color";
         $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/pm_priorities/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('pm_priorities/index', [
                    'items' => $model->get(),
                     'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        if ($id)
            $model = new \modules\pm\models\Pm_priorities('edit');
        else
            $model = new \modules\pm\models\Pm_priorities('add');

        $model->attributes = $this->Input->post();
        $model->_select = "pm_priority_id,name,color";
        if ($id)
            $model->pm_priority_id = $id;

        if ($model->save()) {
            Uri_helper::redirect("management/pm_priorities");
        }
        return $this->render('pm_priorities/manage', [
                    'item' => $id ? $model->get() : null
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id) {
          return  Brightery::error404("The page you requested is not found.");
        }
        $model = new \modules\pm\models\Pm_priorities();
        $model->pm_priority_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/pm_priorities");
    }

}
