<?php defined('ROOT') OR exit('No direct script access allowed');
/**
 * Clinic_schedules Controller
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module Clinic
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/Clinic_schedules
 * @controller Clinic_schedules
 **/
class Clinic_schedulesController extends Brightery_Controller {

    public function indexAction() {
        $this->permission('index');
        $this->language->load("clinic_schedules");
        $info = $this->Database->query("SELECT clinic_schedules.*,
              (SELECT fullname FROM users
              WHERE users.user_id = clinic_doctors.user_id) as fullname "
            . "FROM `clinic_schedules` "
            . "JOIN `clinic_doctors`
                ON `clinic_doctors`.`clinic_doctor_id`=`clinic_schedules`.`clinic_doctor_id`")->result();

        return $this->render('clinic_schedules/index', [
            'items' => $info,
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        
        $this->language->load("clinic_schedules");
        $model = new \modules\clinic\models\Clinic_schedules();
        // TODO: FIX
        $model->attributes[] = $this->Input->post('');
        $model->attributes[] = $this->Input->post('');
        $model->attributes[] = $this->Input->post('');
        $model->attributes[] = $this->Input->post('');
        $model->attributes[] = $this->Input->post('');
        
        $doctors = Form_helper::fullqueryToDropdown('SELECT clinic_doctors.clinic_doctor_id, users.fullname FROM clinic_doctors  INNER JOIN users ON users.user_id = clinic_doctors.user_id', 'clinic_doctor_id', 'fullname');
        if ($id)
            $model->clinic_schedule_id = $id; 
        
        $model->language_id = $this->language->getDefaultLanguage();
        
        if ($model->save()) {
            Uri_helper::redirect("management/clinic_schedules");
        }
        return $this->render('clinic_schedules/manage', [
            'item' => $id ? $model->get() : null,
            'doctor' => $doctors,
            'menu' => [
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday'
            ]
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\clinic\models\Clinic_schedules();
        $model->clinic_schedule_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/clinic_schedules");
    }

}
