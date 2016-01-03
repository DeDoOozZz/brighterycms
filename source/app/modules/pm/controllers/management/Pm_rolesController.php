<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pm_roles Controller
 * @package Brightery CMS
 * @author
 * @version 1.0

 * @interface management
 * @module pm
 * @category general
 * @module_version  1.0

 * @link http://store.brightery.com/module/general/Pm_roles
 * @controller Pm_roles
 * */
class Pm_rolesController extends Brightery_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->language->load("pm_roles");
    }


    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $model = new \modules\pm\models\Pm_roles();
        $model->_select = "pm_role_id, title";
         $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/pm_roles/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('pm_roles/index', [
            'items' => $model->get(),
             'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction ($id = false) {

        $this->permission('manage');
        $model = new \modules\pm\models\Pm_roles();
        $model->attributes = $this->Input->post();
        if ($id)
            $model->pm_role_id = $id;

        if ($model->save()) {
            Uri_helper::redirect("management/pm_roles");
        }
        return $this->render('pm_roles/manage', [
            'item' =>$id ?  $model->get() : null
        ]);


    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
          return   Brightery::error404("The page you requested is not found.");
        }
        $model = new \modules\pm\models\Pm_roles();
        $model->pm_role_id = $id;

        if ($sid = $model->delete())
            return json_encode(['sucess' => 1]);
//        if ($model->delete())
//            Uri_helper::redirect("management/pm_roles");
    }






}