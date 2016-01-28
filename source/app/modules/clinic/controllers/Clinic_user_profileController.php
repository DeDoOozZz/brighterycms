
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
class Clinic_user_profileController extends Brightery_Controller {

    protected $interface = 'frontend';
    protected $layout = 'clinic';

    public function __construct() {
        parent::__construct();
        $this->language->load("clinic_user_profile");
    }

    public function indexAction($id) {

        $userInfo = $this->permissions->getUserInformation('user_id');

        $user_id_log = $userInfo->user_id;

        $user = new \modules\users\models\Users();
        $user->user_id = $id;
        $user->_select = "user_id, fullname, email, password, image, gender, birthdate";
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
                    'phones' => $res,
                    'address' => $add,
                    'patient' => $patient,
                    'diseases' => $diseases,
                    'notes' => $notes,
                    'xrays' => $xrays,
                    'id' => $id,
                    'idlog' => $user_id_log
        ]);
    }

    public function manageAction($id = null) {

        $this->permission('manage');

        if ($_POST) {
            $model = new \modules\users\models\Users();
            $phones = $this->input->post('phone');
            $primary_phone = $this->input->post('primary_phone');
            $primary_address = $this->input->post('primary_address');
            $model->user_id = $id;
            $model->fullname = $this->input->post('fullname');
            $model->birthdate = $this->input->post('birthdate');
            $model->email = $this->input->post('email');
            $model->password = md5($this->input->post('password'));
            $model->gender = $this->input->post('gender');
            $model->save();
            $address = $this->input->post('address');
            $user_phone_id = $this->input->post('user_phone_id');
            $user_address_id = $this->input->post('user_address_id');
            foreach ($phones as $key => $value) {
                if (!$value)
                    continue;
                $prPhone = new \modules\users\models\User_phones();
                $prPhone->_select = 'user_phone_id';
                $prPhone->user_id = $id;
                $prPhone->primary = 1;
                $res = $prPhone->get();
                $userphoneid = $res[0]->user_phone_id;
                $phone = new \modules\users\models\User_phones();
                $phone->user_id = $id;
                $phone->phone = $value;
                if ($user_phone_id[$key] == $primary_phone) {
                    $phone->primary = 1;
                    $pPhone = new \modules\users\models\User_phones();
                    $pPhone->user_phone_id = $userphoneid;
                    $pPhone->primary = 0;
                    $pPhone->save();
                }

                if ($user_phone_id[$key])
                    $phone->user_phone_id = $user_phone_id[$key];
                $phone->save();
            }

            foreach ($address as $key => $value) {
                if (!$value)
                    continue;
                $prAdd = new \modules\users\models\User_addresses();
                $prAdd->_select = 'user_address_id';
                $prAdd->user_id = $id;
                $prAdd->primary = 1;
                $res = $prAdd->get();
                $useraddressid = $res[0]->user_address_id;
                $addres = new \modules\users\models\User_addresses();
                $addres->user_id = $id;
                $addres->address = $value;
                if ($user_address_id[$key] == $primary_address) {
                    $addres->primary = 1;
                    $pAddress = new \modules\users\models\User_addresses();
                    $pAddress->user_address_id = $useraddressid;
                    $pAddress->primary = 0;
                    $pAddress->save();
                }

                if ($user_address_id[$key])
                    $addres->user_address_id = $user_address_id[$key];
                $addres->save();
            }
            $model->save();
        }

        if ($model->save())
            return json_encode(['sucess' => 1,
                'item' => $model,
                'phones' => $phone,
                'address' => $address
            ]);
        else
            return json_encode(['sucess' => 0, 'errors' => $this->validation->errors()]);
    }

    public function deletePhoneAction($id = null) {
        $this->permission('deletePhone');
        $phone = new \modules\users\models\User_phones();
        $phone->user_phone_id = $id;
        if ($phone->delete())
            return TRUE;
        else
            return FALSE;
    }

    public function deleteAddressAction($id = null) {
        $this->permission('deleteAddress');
        $phone = new \modules\users\models\User_addresses();
        $phone->user_address_id = $id;
        if ($phone->delete())
            return TRUE;
        else
            return FALSE;
    }

    public function checkAction($id, $old_password) {
        if ($old_password) {
            $check = new \modules\users\models\Users();
            $check->user_id = $id;
            $check->password = md5($old_password);
            if ($check->get()) {
                return true;
            } else
                return false;
        }
    }

    public function changePasswordAction($id, $new_password) {
        $user = new \modules\users\models\Users();
        $user->user_id = $id;
        $user->password = md5($new_password);
//        print_r($user->attributes);
//        print_r($user->get());
        if ($user->save())
            return true;
    }

}
