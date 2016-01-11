
<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clinic User Profile 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module clinic
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/clinic
 * @controller Clinic_user_profileController
 *
 * */

class Clinic_user_profileController extends Brightery_Controller{


    protected $interface = 'frontend';
    protected $layout = 'clinic';

    public function __construct() {
        parent::__construct();
        $this->language->load("clinic_user_profile");
    }

    public function indexAction($id) {

        $user = new \modules\users\models\Users();
        $user->user_id = $id;
        $user->_select = "user_id, fullname, email, password, image, gender, birthdate";
        $phones = new \modules\users\models\User_phones();
        $phones->_select ="user_phone_id,phone,user_id";
        $phones->user_id = $id;
        $res = $phones->get();
        $user_phone_id = $res[0]->user_phone_id;
        $phones->user_phone_id = $user_phone_id;

        $patient = $this->Database->query("SELECT users.*, `user_addresses`.`address`, `user_phones`.`phone`"
            . "FROM `users` "
            . "LEFT JOIN `user_addresses` ON `user_addresses`.`user_id`=`users`.`user_id`"
            . "LEFT JOIN `user_phones` ON `user_phones`.`user_id`=`users`.`user_id`"
            . "WHERE `users`.`user_id`='$id'"
            . "")->row();

        if (!$patient)
            Brightery::error404();


        $diseases = $this->Database->query("SELECT clinic_patient_diseases.*, `clinic_disease_templates`.`title`"
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

        return $this->render('clinic_user_profile/index', [
                'item' => $user->get(),
                'phones'=>$phones,
                'patient' => $patient,
                'diseases' => $diseases,
                'notes' => $notes,
                'xrays' => $xrays,
                'id' => $id
        ]);
    }

    public function manageAction ($id = null){

        $this->permission('manage');
        $this->layout('ajax');
        print_r($_POST);
        print_r($_GET);
        exit();
        if ($id)

        $model = new \modules\users\models\Users();
            $model->usr_id = $id;
            $phone = new \modules\users\models\User_phones();
            $phone->_select = 'user_phone_id ,phone';
            $phone->user_id = $id;
            $res = $phone->get();
            $user_phone_id = $res[0]->user_phone_id;
            $phone->user_phone_id = $user_phone_id;
        if ($_POST)
        {
            $model->attributes['fullname'] = $this->input->post('fullname');
            $model->attributes['birthdate'] = $this->input->post('birthdate');
            $model->attributes['email'] = $this->input->post('email');
            $model->attributes['gender'] = $this->input->post('gender');

        }
        if ($id) {
            $model->user_id = $id;
            $phone->user_id = $id;
        }
        $phone->phone = $this->input->post('phone');
        if ($sid = $model->save())
            return json_encode(['sucess' => 1, 'id' => $sid, 'item' =>$model,
                'phones' => $phone]);

        else
            return json_encode(['sucess' => 0, 'errors' => $this->validation->errors()]);


    }

}

