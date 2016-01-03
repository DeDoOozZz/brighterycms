<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clinic_doctor_reservation_types Controller
 * @package Brightery CMS
 * @author <marwa.elmanawy@brightery.com>
 * @version 1.0

 * @interface management
 * @module clinic
 * @category general
 * @module_version  1.0

 * @link http://store.brightery.com/module/general/Clinic_doctor_reservation_types
 * @controller Clinic_doctor_reservation_types
 * */
class Clinic_doctor_reservation_typesController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction() {
        $this->permission('index');
        $this->language->load("clinic_doctor_reservation_types");
        $info = $this->Database->query("SELECT clinic_doctor_reservation_types.*, (SELECT fullname FROM users WHERE users.user_id = clinic_doctors.user_id) as fullname "
            . "FROM `clinic_doctor_reservation_types` "
            . "JOIN `clinic_doctors` ON `clinic_doctors`.`clinic_doctor_id`=`clinic_doctor_reservation_types`.`clinic_doctor_id`"
            . "")->result();

        return $this->render('clinic_doctor_reservation_types/index', [
            'items' => $info,
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $this->language->load("clinic_doctor_reservation_types");
        $model = new \modules\clinic\models\clinic_doctor_reservation_types();
        $model->attributes = $this->Input->input['post'];

        $doctors = Form_helper::fullqueryToDropdown('SELECT clinic_doctors.clinic_doctor_id, users.fullname FROM clinic_doctors  INNER JOIN users ON users.user_id = clinic_doctors.user_id', 'clinic_doctor_id', 'fullname');
      
        if ($id)
            $model->clinic_doctor_reservation_type_id = $id; 
        
        $model->language_id = $this->language->getDefaultLanguage();

        if ($model->save()) {
            Uri_helper::redirect("management/clinic_doctor_reservation_types");
        }
        return $this->render('clinic_doctor_reservation_types/manage', [
            'item' => $id ? $model->get() : null,
            'doctor' => $doctors
            
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\clinic\models\Clinic_doctor_reservation_types();
        $model->clinic_doctor_reservation_type_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/clinic_doctor_reservation_types");
    }

}
