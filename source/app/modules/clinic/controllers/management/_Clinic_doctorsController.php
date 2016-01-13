<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clinic_doctors Controller
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module clinic
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/Clinic_doctors
 * @controller Clinic_doctors
 * */
class Clinic_doctorsController extends Brightery_Controller {

    protected $layout = 'default';

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->language->load("clinic_doctors");
        $model = new \modules\clinic\models\Clinic_doctors();
        $model->_select = "clinic_doctor_id,(SELECT users.fullname FROM users WHERE users.user_id = clinic_doctors.user_id)
         AS doctor_name";

        $users = ['' => 'select..'];
        foreach ($model->get() as $item) {
            $users[$item->clinic_doctor_id] = $item->doctor_name;
        }
        $model->_select = ' clinic_doctors.*,`clinic_specifications`.`specification`,`users`.`fullname`';
        $model->_joins = [
            'clinic_specifications' => ['`clinic_specifications`.`clinic_specification_id`=`clinic_doctors`.`clinic_specification_id`', 'INNER'],
            'users' => ['`users`.`user_id`=`clinic_doctors`.`user_id`', 'INNER']];

        $specification = Form_helper::queryToDropdown('clinic_specifications', 'clinic_specification_id', 'specification');
        if ($this->input->get('doctor_id'))
            $model->where('clinic_doctors.clinic_doctor_id', $this->input->get('doctor_id'));
        if ($this->input->get('specification_id'))
            $model->where('clinic_doctors.clinic_specification_id', $this->input->get('specification_id'));

        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/clinic_doctors/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];

        return $this->render('clinic_doctors/index', [
                    'items' => $model->get(),
                    'users' => $users,
                    'specification' => $specification,
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = null) {
        $this->permission('manage');

        $this->language->load("clinic_doctors");
        $model = new \modules\clinic\models\Clinic_doctors();
        $specifications = Form_helper::queryToDropdown('clinic_specifications', 'clinic_specification_id', 'specification');
        $users_fullname = Form_helper::queryToDropdown('users', 'user_id', 'fullname');
        $users_phone = Form_helper::queryToDropdown('user_phones', 'user_id', 'phone');
        $users_email = Form_helper::queryToDropdown('users', 'user_id', 'email');

        if ($id)
            $model->clinic_doctor_id = $id;

        $this->input->post($this->input->post('criteria'));

        if ($_POST) {
            $model->attributes['user_id'] = $this->input->post('user_id')/* $this->input->post($this->input->post('criteria')) */;
            $model->attributes['clinic_specification_id'] = $this->input->post('clinic_specification_id');
            $model->attributes['description'] = $this->input->post('description');
            $model->attributes['period_average'] = $this->input->post('period_average');
        }
        if ($model->save()) {
            Uri_helper::redirect("management/clinic_doctors");
        } else {
            return $this->render('clinic_doctors/manage', [
                        'item' => $id ? $model->get() : null,
                        'menu' => ['male' => 'Male', 'female' => 'Female'],
                        'user_fullname' => $users_fullname,
                        'user_phone' => $users_phone,
                        'user_email' => $users_email,
                        'specification' => $specifications,
                        'user_id' => $this->input->get('user_id')
            ]);
        }
    }

    public function doctor_scheduleAction($id) {
        $this->permission('doctor_schedule');
        $this->language->load("clinic_doctors");
        $model = new \modules\clinic\models\Clinic_schedules();
        $model->clinic_doctor_id = $id;
        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        if ($_POST) {
            $for_time = $this->input->post('from');
            $to_time = $this->input->post('to');
            $status = $this->input->post('day');
            $clinic_schedule_id = $this->input->post('clinic_schedule_id');
            foreach ($this->input->post('from') as $key => $value) {
                if ($clinic_schedule_id[$key])
                    $model->clinic_schedule_id = $clinic_schedule_id[$key];
                $model->day = $days[$key];
                $model->from_time = $for_time[$key];
                $model->to_time = $to_time[$key];
                if ($status[$key] == 1)
                    $model->status = 'on';
                else
                    $model->status = 'off';
                $model->save();
            }
            $model->reset();
            $model->clinic_doctor_id = $id;
        }


        $schedule = [];
        foreach ($model->get() as $item) {
            $schedule[$item->day] = $item;
        }

        return $this->render('clinic_doctors/doctor_schedule', [
                    'item' => $schedule,
        ]);
    }

    public function schedule_exceptionsAction($id = false) {

        $this->layout = 'ajax';
        $this->permission('schedule_exceptions');
        $exceptions = new \modules\clinic\models\Clinic_schedule_exceptions();
        $exceptions->clinic_doctor_id = $id;
        $exceptions->date = $this->input->post('exc_date');
        $exceptions->from_time = $this->input->post('exc_from');
        $exceptions->to_time = $this->input->post('exc_to');

        $exp_schedule = [];
        foreach ($exceptions->get() as $item) {
            $exp_schedule[$item->clinic_doctor_id] = $item;
        }
        $exceptions->save();
        return $this->render('clinic_doctors/exceptions', [
                    'exp_schedule' => $exp_schedule,
                    'doctor' => $id
        ]);
    }

    public function delete_schedule_exceptionsAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $exceptions = new \modules\clinic\models\Clinic_schedule_exceptions();

        $exceptions->clinic_schedule_exception_id = $id;

        if ($sid = $exceptions->delete())
            return json_encode(['sucess' => 1]);
    }

    public function get_user_informationAction($id = NULL) {
        if (!$id)
            return Brightery::error404();
        $this->layout = 'ajax';
        $user = new \modules\users\models\Users();
        $user->_select = "`users`.`fullname`, `users`.`gender`, `users`.`email`, (SELECT phone FROM user_phones WHERE `primary` = '1' AND user_phones.user_id = users.user_id LIMIT 1) AS phone";
        $user->user_id = $id;
        return json_encode(['user' => $user->get()]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model_schedules = new \modules\clinic\models\Clinic_schedules();
        $model_schedules->clinic_doctor_id = $id;

        $model_exceptions = new modules\clinic\models\Clinic_schedule_exceptions();
        $model_exceptions->clinic_doctor_id = $id;

        $model = new \modules\clinic\models\Clinic_doctors();
        $model->clinic_doctor_id = $id;

        $model_resevration_type = new \modules\clinic\models\Clinic_doctor_reservation_types();
        $model_resevration_type->clinic_doctor_id = $id;

        $model_reservation = new \modules\clinic\models\Clinic_reservations();
        $model_reservation->clinic_doctor_id = $id;

        if ($model->delete() && $model_exceptions->delete() && $model_schedules->delete() && $model_resevration_type->delete() && $model_reservation->delete())
            Uri_helper::redirect("management/clinic_doctors");
    }

}
