<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Patients Controller
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module clinic
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/patients
 * @controller Clinic_patients
 *
 * */
class Clinic_patientsController extends Brightery_Controller {

    protected $layout = 'default';

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->language->load("clinic_patients");
        $model = new \modules\users\models\Users();
        $model->_select = "user_id, fullname";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/clinic_patients/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('clinic_patients/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function detailsAction($id = null) {
        $this->permission('index');
        if (!$id)
            return Brightery::error404();

        $this->language->load("clinic_patients");


        $patient = $this->Database->query("SELECT users.*, `user_addresses`.`address`, `user_phones`.`phone`"
                        . "FROM `users` "
                        . "LEFT JOIN `user_addresses` ON `user_addresses`.`user_id`=`users`.`user_id`"
                        . "LEFT JOIN `user_phones` ON `user_phones`.`user_id`=`users`.`user_id`"
                        . "WHERE `users`.`user_id`='$id'"
                        . "")->row();

        if (!$patient)
            Brightery::error404();
        $phones = new \modules\users\models\User_phones();
        $phones->_select = "user_phone_id, phone, user_id , `primary`";
        $phones->user_id = $id;
        $res = $phones->get();
        $user_phone_id = $res[0]->user_phone_id;
        $phones->user_phone_id = $user_phone_id;

        $address = new modules\users\models\User_addresses();
        $address->select = 'user_address_id ,user_id';
        $address->user_id = $id;
        $add = $address->get();


        $info = $this->Database->query("SELECT clinic_patient_diseases.*, `clinic_disease_templates`.`title`"
                        . "FROM `clinic_patient_diseases` "
                        . "JOIN `clinic_disease_templates` ON `clinic_disease_templates`.`clinic_disease_template_id`=`clinic_patient_diseases`.`clinic_disease_template_id`"
                        . "JOIN `users` ON `users`.`user_id`=`clinic_patient_diseases`.`user_id`"
                        . "WHERE `clinic_patient_diseases`.`user_id`='$id'"
                        . "")->result();

        $notes = $this->Database->query("SELECT clinic_patients_notes.*, (SELECT fullname FROM users WHERE clinic_doctors.user_id = users.user_id ) as doctor_name"
                        . " FROM clinic_patients_notes "
                        . " LEFT JOIN clinic_doctors ON clinic_doctors.clinic_doctor_id = clinic_patients_notes.clinic_doctor_id "
                        . "WHERE clinic_patients_notes.user_id = '$id'")->result();

        $xrays = $this->Database->query("SELECT clinic_xray_negative.*"
                        . " FROM clinic_xray_negative "
                        . "WHERE clinic_xray_negative.user_id = '$id'")->result();



        return $this->render('clinic_patients/details', [
                    'patient' => $patient,
                    'diseases' => $info,
                    'phones' => $res,
                    'address' => $add,
                    'notes' => $notes,
                    'xrays' => $xrays,
                    'id' => $id
        ]);
    }

}
