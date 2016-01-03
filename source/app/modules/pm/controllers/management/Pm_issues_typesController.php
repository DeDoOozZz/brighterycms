<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pm_issues_types Controller
 * @package Brightery CMS
 * @author 
 * @version 1.0

 * @interface management
 * @module pm
 * @category general
 * @module_version  1.0

 * @link http://store.brightery.com/module/general/Pm_issues_types
 * @controller Pm_issues_types
 * */
class Pm_issues_typesController extends Brightery_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->language->load("pm_issues_types");

    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $model = new \modules\pm\models\Pm_issues_types();
        $model->_select = "pm_issue_type_id,title";
         $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/pm_issues_types/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('pm_issues_types/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        if ($id)
            $model = new \modules\pm\models\Pm_issues_types('edit');
        else
            $model = new \modules\pm\models\Pm_issues_types('add');
        
        $model->attributes = $this->Input->post();
        if ($id)
            $model->pm_issue_type_id = $id;
        
        if ($model->save()) {
            Uri_helper::redirect("management/pm_issues_types");
        }
        return $this->render('pm_issues_types/manage', [
                    'item' => $id ? $model->get() : null
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
           return  Brightery::error404("The page you requested is not found.");
        }
        $model = new \modules\pm\models\Pm_issues_types();
        $model->pm_issue_type_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/pm_issues_types");
    }

}
