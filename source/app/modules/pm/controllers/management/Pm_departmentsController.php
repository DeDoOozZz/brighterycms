<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Departments controller
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@info.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pm_announcements
 * @controller Departments
 *
 **/

class Pm_departmentsController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';

    public  function indexAction (){
      $this ->auth = true;
        $this -> permission('index');
        $this->language ->load('pm_departments');
        $model = new \modules\pm\models\Pm_departments();
        $model ->select = "pm_department_id, title, description";
        return $this -> render('pm_departments/index', [
                'items' => $model ->get()
            ]);

    }

    public function manageAction ($id = false){

        $this -> auth = true;
        $this->permission('manage');
        $this -> language -> load ('pm_departments');
        $model = new \modules\pm\models\Pm_departments();
        $model->attributes = $this->Input->post();
        if ($id)
            $model->pm_department_id = $id;
        if (!$id)
            $model->created = date("Y-m-d H:i:s");
        if ($model -> save())
            Uri_helper::redirect("management/pm_departments");
        else
            return $this -> render("pm_departments/manage" , [
                    'item' =>$id ? $model-> get() : null
                ]

            );

    }
    public function deleteAction ($id = false){

        $this->permission('delete');
        if(!$id)
            Brightery::error404("The page you requested is not found.");
            $model = new \modules\pm\models\Pm_departments();
            $model-> pm_department_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/pm_departments");

    }
}