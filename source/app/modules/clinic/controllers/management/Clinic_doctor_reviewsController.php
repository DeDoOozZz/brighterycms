<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clinic_doctor_reviews Controller
 * @package Brightery CMS
 * @author <marwa.elmanawy@brightery.com> 
 * @version 1.0

 * @interface management
 * @module clinic
 * @category general
 * @module_version  1.0

 * @link http://store.brightery.com/module/general/Clinic_doctor_reviews
 * @controller Clinic_doctor_reviews
 * */
class Clinic_doctor_reviewsController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->language->load("clinic_doctor_reviews");
        $model = new \modules\clinic\models\clinic_doctor_reviews();
        $info = $this->Database->query("SELECT clinic_doctor_reviews.*, (SELECT fullname FROM users WHERE users.user_id = clinic_doctors.user_id) as fullname, (SELECT fullname FROM users WHERE users.user_id = clinic_patients.user_id) as patient "
                        . "FROM `clinic_doctor_reviews` "
                        . "JOIN `clinic_doctors` ON `clinic_doctors`.`clinic_doctor_id`=`clinic_doctor_reviews`.`clinic_doctor_id`"
                        . "JOIN `clinic_patients` ON `clinic_patients`.`clinic_patient_id`=`clinic_doctor_reviews`.`clinic_patient_id`"
                        . "")->result();

        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/clinic_doctor_reviews/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('clinic_doctor_reviews/index', [
                    'items' => $info,
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        $this->language->load("clinic_doctor_reviews");
        $model = new \modules\clinic\models\clinic_doctor_reviews();
        $model->attributes = $this->Input->input['post'];

        $doctors = Form_helper::fullqueryToDropdown('SELECT clinic_doctors.clinic_doctor_id, users.fullname FROM clinic_doctors  INNER JOIN users ON users.user_id = clinic_doctors.user_id', 'clinic_doctor_id', 'fullname');
        $patients = Form_helper::fullqueryToDropdown('SELECT clinic_patients.clinic_patient_id, users.fullname FROM clinic_patients  INNER JOIN users ON users.user_id = clinic_patients.user_id', 'clinic_patient_id', 'fullname');

        if ($id)
            $model->clinic_doctor_review_id = $id;

        $model->language_id = $this->language->getDefaultLanguage();

        if ($model->save()) {
            Uri_helper::redirect("management/clinic_doctor_reviews");
        }
        return $this->render('clinic_doctor_reviews/manage', [
                    'item' => $id ? $model->get() : null,
                    'doctor' => $doctors,
                    'patient' => $patients
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\clinic\models\Clinic_doctor_reviews();
        $model->clinic_doctor_review_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/clinic_doctor_reviews");
    }

}
