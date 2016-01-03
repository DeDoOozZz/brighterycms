<?php defined('ROOT') OR exit('No direct script access allowed');
/**
 * Clinic_schedule_exceptions Controller
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module clinic
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/Clinic_schedule_exceptions
 * @controller Clinic_schedule_exceptions
 **/

class Clinic_schedule_exceptionsController extends Brightery_Controller {

    public function indexAction() {
        $this->permission('index');
        $this->language->load("clinic_schedule_exceptions");

//        $info = $this->Database->query("SELECT *,`clinic_schedules`.`clinic_schedule_id"
//            . "FROM `clinic_schedule_exceptions` "
//            . "JOIN `clinic_schedules` ON `clinic_schedules`.`clinic_schedule_id`=`clinic_schedule_exceptions`.`clinic_schedule_id`" 
//            . "")->result();

//        print_r($info);
        $info = $this->Database->query("SELECT *"
            . "FROM `clinic_schedule_exceptions` "
            . "")->result();
        return $this->render('clinic_schedule_exceptions/index', [
            'items' => $info,
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        $this->language->load("clinic_schedule_exceptions");
        $model = new \modules\clinic\models\Clinic_schedule_exceptions();
        
        $model->attributes = $this->Input->input['post'];
        $schedules = Form_helper::queryToDropdown('clinic_schedules', 'clinic_schedule_id', 'clinic_schedule_id');
        if ($id)
            $model->clinic_schedule_exception_id = $id; 
        $model->language_id = $this->language->getDefaultLanguage();
        
        if ($model->save()) {
            Uri_helper::redirect("management/clinic_schedule_exceptions");
        }
        return $this->render('clinic_schedule_exceptions/manage', [
            'item' => $id ? $model->get() : null,
            'schedule' => $schedules,
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\clinic\models\Clinic_schedule_exceptions();
        $model->clinic_schedule_exception_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/clinic_schedule_exceptions");
    }

}
