<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clinic_reservations Controller
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module clinic
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/clinic
 * @controller Clinic_reservations
 * */
class Clinic_reservationsController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction($offset = 0) {

        $this->permission('index');
        $this->language->load("clinic_reservations");
        $model = new \modules\clinic\models\Clinic_reservations();
        if ($this->input->get()) {
            $patient = Form_helper::queryToDropdown('users', 'clinic_patient_id', 'fullname', null, 'join clinic_patients on clinic_patients.user_id=users.user_id');
            $status = ['attend' => $this->Language->phrase('attend'), 'late' => $this->Language->phrase('late'), 'entered' => $this->Language->phrase('entered'), 'canceled' => $this->Language->phrase('canceled')];
            $doctor = Form_helper::queryToDropdown('users', 'clinic_doctor_id', 'fullname', null, 'join clinic_doctors on clinic_doctors    .user_id = users.user_id');
            $user_id = $this->input->get('user_id');
            if ($this->input->get('date'))
                $model->date = $this->input->get('date');
            if ($this->input->get('user_id')) {
                $model->where('`users`. `user_id`', $this->input->get('user_id'));
            }
            if ($this->input->get('status'))
                $model->where('`clinic_reservations`. `status`', $this->input->get('status'));
            if ($this->input->get('doctor_id'))
                $model->clinic_doctor_id = $this->input->get('doctor_id');
//            $this->load->library('pagination');
            $model->_select = "clinic_reservations.* , `users`.`fullname`";
            $model->_joins = [ 'users' => ["`users`.`user_id` = `clinic_reservations`.`user_id`"],
            ];
            return $this->render('clinic_reservations/index', [
                        'items' => $model->get(),
                        'patient' => $patient,
                        'doctor' => $doctor,
                        'status' => $status
//                        'pagination' => $this->Pagination->generate($config)
            ]);
        }
        elseif (!$this->input->get()) {
            $patient = Form_helper::queryToDropdown('users', 'clinic_patient_id', 'fullname', null, 'join clinic_patients on clinic_patients.user_id=users.user_id');
            $status = ['attend' => $this->Language->phrase('attend'), 'late' => $this->Language->phrase('late'), 'entered' => $this->Language->phrase('entered'), 'canceled' => $this->Language->phrase('canceled')];
            $doctor = Form_helper::queryToDropdown('users', 'clinic_doctor_id', 'fullname', null, 'join clinic_doctors on clinic_doctors    .user_id = users.user_id');
//        $model->_select = 'clinic_reservations.*,`clinic_doctor_reservation_types`.`title`,`clinic_schedules`.`clinic_schedule_id`, `users`.`fullname`';
//        $model->_joins = [
//            'clinic_schedules' => ['`clinic_schedules`.`clinic_schedule_id`=`clinic_reservations`.`clinic_schedule_id`', 'INNER'],
//            'users' => ['`users`.`user_id`=`clinic_reservations`.`user_id`', 'INNER'],
//            'clinic_doctor_reservation_types' => ['`clinic_doctor_reservation_types`.`clinic_doctor_reservation_type_id`=`clinic_reservations`.`clinic_doctor_reservation_type_id`', 'INNER'],
//        ];
            $model->_select = "clinic_reservations.* , `users`.`fullname` ";
            $model->_joins = [ 'users' => ["`users`.`user_id` = `clinic_reservations`.`user_id`"],
            ];

            $this->load->library('pagination');
            $model->_limit = $this->config->get('limit');
            $model->_offset = $offset;
            $config = [
                'url' => Uri_helper::url('management/clinic_reservations/index'),
//            'total' => $model->get(true),
                'limit' => $model->_limit,
                'offset' => $model->_offset
            ];
            return $this->render('clinic_reservations/index', [
                        'items' => $model->get(),
                        'patient' => $patient,
                        'doctor' => $doctor,
                        'status' => $status,
                        'pagination' => $this->Pagination->generate($config)
            ]);
        }
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        $this->language->load("clinic_reservations");
        $model = new \modules\clinic\models\Clinic_reservations();
        $model->language_id = $this->language->getDefaultLanguage();

        $doctor = Form_helper::queryToDropdown('users', 'clinic_doctor_id', 'fullname', null, 'join clinic_doctors on clinic_doctors.user_id = users.user_id');
        $model->attributes = $this->Input->input['post'];
        $clinic_reservation_status = ['confirmed' => $this->Language->phrase('confirmed'),
            'canceled' => $this->Language->phrase('canceled'),
            'pending' => $this->Language->phrase('pending')];
        $schedules = Form_helper::queryToDropdown('clinic_schedules', 'clinic_schedule_id', 'clinic_schedule_id');
        $patients = Form_helper::queryToDropdown('users', 'user_id', 'fullname');

//        $patients = Form_helper::fullqueryToDropdown('SELECT clinic_patients.clinic_patient_id, users.fullname FROM clinic_patients  INNER JOIN users ON users.user_id = clinic_patients.user_id', 'clinic_patient_id', 'fullname');
        if ($id)
            $model->clinic_reservation_id = $id;
        $model->language_id = $this->language->getDefaultLanguage();
        if (!$id)
            $model->created = date("Y-m-d H:i:s");

        if ($model->save()) {
            Uri_helper::redirect("management/clinic_reservations");
        }
        $final = null;
        if ($_POST)
            $final = $this->getSearch();
        return $this->render('clinic_reservations/manage', [
                    'item' => $id ? $model->get() : null,
                    'patient' => $patients,
                    'schedule' => $schedules,
                    'reservation_type' => $reservation_type,
                    'clinic_reservation_status' => $clinic_reservation_status,
                    'doctors' => $doctor,
//        'final' => $final
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\clinic\models\Clinic_reservations();
        $model->clinic_reservation_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/clinic_reservations");
    }

    public function getSearchAction() {
        $this->layout = 'ajax';
        $doctor_id = $this->input->get('user_id');
        $date = $this->input->get('date');
        $model_period = new \modules\clinic\models\Clinic_doctors();
        $model_period->_select = 'period_average ';
        $model_period->clinic_doctor_id = $doctor_id;
        $period_time = $model_period->get();
        $average_time = $period_time->period_average;
        /////////////////////get day////////////////////////////////////////
        $timestamp = strtotime($date);
        $day = date("l", $timestamp);
        $model_date = new \modules\clinic\models\Clinic_schedules();
        $model_date->_select = 'from_time , to_time ';
        $model_date->clinic_doctor_id = $doctor_id;
        $model_date->day = $day;
        $period = $model_date->get();
        if (!$period)
            return json_encode(['result' => 0]);

        $from = $period[0]->from_time;
        $to = $period[0]->to_time;

        $time = $model_date->get_time($from, $to, $average_time, $doctor_id);
        $final = $model_date->get_searchResult($date, $time, $doctor_id);
        return json_encode([ 'result' => $final]);
    }

    public function getdoctorTypesAction() {
        $doctor_id = $this->input->get('user_id');
        $reservation_type = Form_helper::queryToDropdown('clinic_doctor_reservation_types', 'clinic_doctor_reservation_type_id', 'title', null, 'WHERE clinic_doctor_id = "' . $doctor_id . '"');
        return $this->render('clinic_reservations/manage', [
                    'reservation_type' => $reservation_type
        ]);
    }

    public function get_doctorAction() {
        $id = $this->input->post('id');
        $data = $this->Database->query("select clinic_doctor_reservation_type_id,title from clinic_doctor_reservation_types where clinic_doctor_id=$id")->result();
        if (!$data) {
            echo "<option value=\"\">Select ...</option>";
        }
        if ($data) {
            echo "<option value=\"\">Select ...</option>";
            foreach ($data as $value) {
                echo '<option value=' . $value->clinic_doctor_reservation_type_id . '>' . $value->title . '</option>';
            }
        }
    }

    public function saveAction() {
        $clinic_doctor_id = $this->input->post('doctor_id');
        $user_id = $this->input->post('patient_id');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $status = $this->input->post('status');
//        $clinic_doctor_reservation_type_id = $this->input->post('clinic_doctor_reservation_type_id');
        $model_res = new \modules\clinic\models\Clinic_reservations(FALSE);
        $model_res->created = date("Y-m-d H:i:s");
        $model_res->time = $time;
        $model_res->date = $date;
        $model_res->user_id = $user_id;
        $model_res->clinic_doctor_id = $clinic_doctor_id;
//        $model_res->clinic_doctor_reservation_type_id = $clinic_doctor_reservation_type_id;
        $model_res->clinic_reservation_status = $status;
        $model_res->status = '';
        if ($model_res->save())
            return true;
        else
            return false;
    }

}
