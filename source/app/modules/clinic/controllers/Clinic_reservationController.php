<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clinic_reservations Controller
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * @interface frontend
 * @module clinic
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/clinic
 * @controller Clinic_reservationController
 * */
class Clinic_reservationController extends Brightery_Controller {

    protected $interface = 'frontend';
    protected $layout = 'default';

    public function indexAction($offset = 0) {
        $this->language->load("clinic_reservations");
        $branches = Form_helper::queryToDropdown('clinic_branches', 'clinic_branch_id', 'clinic_branch');
        $specification = Form_helper::queryToDropdown('clinic_specifications', 'clinic_specification_id', 'specification');
        $doctors = new \modules\clinic\models\clinic_doctors();
        $doctors->_select = "clinic_doctor_id,(SELECT users.fullname FROM users WHERE users.user_id = clinic_doctors.user_id)
         AS doctor_name";


        $users = ['' => 'select..'];
        foreach ($doctors->get() as $item) {
            $users[$item->clinic_doctor_id] = $item->doctor_name;
        }

        $doctors->_select = "users.fullname,users.image,specification,clinic_branch,clinic_doctor_id";

        $doctors->_joins = [
            'users' => ['clinic_doctors.`user_id` = users.`user_id`'],
            'clinic_specification_branches' => ['clinic_doctors.`clinic_specification_id` = clinic_specification_branches.`clinic_specification_id`'],
            'clinic_specifications' => ['clinic_specifications.`clinic_specification_id` = clinic_doctors.`clinic_specification_id`'],
            'clinic_branches' => ['clinic_branches.`clinic_branch_id` =`clinic_specification_branches`.`clinic_branch_id`']
        ];
        $doctors->_group_by = [
            ['clinic_doctors.`clinic_doctor_id`']
        ];
        $doctors->_order_by = false;

        if ($this->input->get('clinic_branch_id')) {
            $doctors->where('clinic_branches.`clinic_branch_id`', $this->input->get('clinic_branch_id'));
        }
        if ($this->input->get('specification_id')) {
            $doctors->where('clinic_specifications.`clinic_specification_id`', $this->input->get('specification_id'));
        }
        if ($this->input->get('clinic_doctor_id')) {
            $doctors->where('clinic_doctors.`clinic_doctor_id`', $this->input->get('clinic_doctor_id'));
        }


        $this->load->library('pagination');
        $doctors->_limit = $this->config->get('limit');
        $doctors->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('clinic_reservation/index'),
            'total' => $doctors->get(true),
            'limit' => $doctors->_limit,
            'offset' => $doctors->_offset
        ];


        return $this->render('clinic_reservations/clinic_reservations', [

                    'branches' => $branches,
                    'specification' => $specification,
                    'doctors' => $doctors->get(),
                    'users' => $users,
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function get_scheduleAction($id) {

        $model_id = new \modules\clinic\models\Clinic_doctors();
        $model_id->_select = 'user_id';
        $model_id->clinic_doctor_id = $id;
        $resuser_id = $model_id->get();
        $user_id = $resuser_id->user_id;
        
        $model = new \modules\users\models\Users();
        $model->_select = 'user_id , fullname';
        $model->status = 'active';
        $model->user_id = $user_id;

        ////////////////////////////Clinic Schedule Exceptions//////////////////
        $model_Expcetion = new \modules\clinic\models\Clinic_schedule_exceptions();
        ////////////////////////////doctors//////////////////////////////////
        $model_doctors = new \modules\clinic\models\Clinic_doctors();
        $model_doctors->_select = 'clinic_doctor_id, period_average';
        $model_doctors->user_id = $user_id;
        $res = $model_doctors->get();
        $period = $res[0]->period_average;
        $doctor_id = $res[0]->clinic_doctor_id;


        ////////////////////////////doctors//////////////////////////////////
        $model_type = new \modules\clinic\models\Clinic_doctor_reservation_types();
        $model_type->_select = 'clinic_doctor_reservation_type_id, title , price';
        $model_type->clinic_doctor_id = $id;
        $type_result = $model_type->get();

        /////////////////////////////Clinic Schedules///////////////////////////
        $model_schedule = new \modules\clinic\models\Clinic_schedules();
        $model_schedule->_select = 'clinic_schedule_id ,clinic_doctor_id, day , from_time , to_time ';
        $model_schedule->clinic_doctor_id = $doctor_id;
        $time = $model_schedule->get();
        $from = $time[0]->from_time;
        $to = $time[0]->to_time;
        foreach ($time as $key => $value) {
            if (strtotime($from) > strtotime($time[$key]->from_time)) {
                $from = $time[$key]->from_time;
            }
            if (strtotime($to) < strtotime($time[$key]->to_time)) {
                $to = $time[$key]->to_time;
            }
        }
        
         ;
        $result = $model_schedule->get();
        $time = $model_schedule->get_time($from, $to, $period, $doctor_id);
        $exceptions = $model_schedule->exceptions($doctor_id);
        $date_new = $model_schedule->get_newDate();
        $reserved = $model_schedule->get_schedule($date_new, $time, $doctor_id);
        $model_schedule->pre($reserved, $result, $date_new);
        $final = $model_schedule->Final_Array($reserved, $exceptions);
        $userInfo = $this->permissions->checkUserCredentials();
        return $this->render('clinic_reservations/clinic_schedule', [
                    'dates' => $date_new,
                    'items' => $model->get(),
                    'item_schedule' => $result,
                    'finals' => $final,
                    'time' => $time,
                    'reserved' => $reserved,
                    'user' => $userInfo,
                    'type' => $type_result,
        ]);
    }

    /* public function indexAction() {
      $this->language->load("clinic_reservations");
      $searchkey = $this->input->get('searchkey');
      $clinic_specification_id = $this->input->get('clinic_specification_id');
      $branches = Form_helper::queryToDropdown('clinic_branches', 'clinic_branch_id', 'clinic_branch');
      $doctors = new \modules\clinic\models\Clinic_doctors();

      //        $doctors->_joins = [
      //            ['users' => ['users.user_id = clinic_doctors.user_id', 'inner']],
      //            ['clinic_specifications' => ['clinic_specifications.user_id = clinic_doctors.user_id', 'inner']],
      //        ];

      //        $info = $this->Database->query("SELECT `users`.`user_id` , `users`.`image` , `users`.`fullname` , `clinic_doctors`.`description` , `clinic_branches`.`address` ,`clinic_specifications`.`specification` FROM `clinic_doctors`
      //            JOIN `users` ON `clinic_doctors`.`user_id` = `users`.`user_id`
      //                JOIN `clinic_specifications` ON `clinic_doctors`.`clinic_specification_id` = `clinic_specifications`.`clinic_specification_id`
      //                JOIN `clinic_branches` ON `clinic_specifications`.`clinic_branch_id` = `clinic_branches`.`clinic_branch_id`
      //                WHERE `clinic_doctors` .`clinic_specification_id` = '$clinic_specification_id'
      //                AND `users`.`fullname` LIKE '%$searchkey%'")->result();

      return $this->render('clinic_reservations/clinic_reservations', [
      'items' => $info,
      'branches' => $branches,
      ]);


      //        return $this->render('clinic_reservations/clinic_reservations',
      ['branches' => $branches, 'specification' => $specifications]);
      } */

//     public function getspeceificationAction() {
//        $id = $this->input->post('clinic_branch_id');
//        $spec = Form_helper::queryToDropdown('clinic_specifications', 'clinic_specification_id', 'specification', null, "WHERE `clinic_branch_id` = '$id'");
//        $res = null;
//        foreach ($spec as $key => $value) {
//            $res .= "<option value='$key'>$value</option>";
//        }
//        echo $res;
//    }


    /* public function getdoctorsAction() {
      $searchkey = $this->input->get('searchkey');
      $clinic_specification_id = $this->input->get('clinic_specification_id');
      $branches = Form_helper::queryToDropdown('clinic_branches', 'clinic_branch_id', 'clinic_branch');

      $info = $this->Database->query("SELECT `users`.`user_id` , `users`.`image` , `users`.`fullname` , `clinic_doctors`.`description` , `clinic_branches`.`address` ,`clinic_specifications`.`specification` FROM `clinic_doctors`
      JOIN `users` ON `clinic_doctors`.`user_id` = `users`.`user_id`
      JOIN `clinic_specifications` ON `clinic_doctors`.`clinic_specification_id` = `clinic_specifications`.`clinic_specification_id`
      JOIN `clinic_branches` ON `clinic_specifications`.`clinic_branch_id` = `clinic_branches`.`clinic_branch_id`
      WHERE `clinic_doctors` .`clinic_specification_id` = '$clinic_specification_id'
      AND `users`.`fullname` LIKE '%$searchkey%'")->result();

      return $this->render('clinic_reservations/clinic_reservations', [
      'items' => $info,
      'branches' => $branches,
      ]);
      }
     */




    /* public function get_dateAction($d) {
      $date = $d;
      $model_schedule = new \modules\clinic\models\Clinic_schedules();
      $the_date = $model_schedule->get_date($date);
      return $the_date;
      }
     */
    /* public function checkAction() {
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $model = new \modules\users\models\Users();
      $model->_select = "user_id";
      $model->email = $email;
      $model->password = md5($password);
      if ($model->get()) {
      return true;
      } else
      return false;
      }
     */

    public function saveAction() {
        $email = $this->input->post('email');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $clinic_schedule_id = $this->input->post('clinic_schedule_id');
        $clinic_doctor_reservation_type_id = $this->input->post('clinic_doctor_reservation_type_id');
        print_r($_POST);
        $model = new \modules\users\models\Users();
        $model->_select = "user_id";
        $model->email = $email;
        if ($model->get()) {
            $user = $model->get();
            echo $user_id = $user[0]->user_id;
            $model_res = new \modules\clinic\models\Clinic_reservations(FALSE);
            $model_res->created = date("Y-m-d H:i:s");
            $model_res->time = $time;
            $model_res->date = $date;
            $model_res->user_id = $user_id;
            $model_res->clinic_schedule_id = $clinic_schedule_id;
            $model_res->clinic_doctor_reservation_type_id = $clinic_doctor_reservation_type_id;
            $model_res->clinic_reservation_status = 'pending';
            $model_res->status = '';
            if ($model_res->save())
                return true;
            else
                return false;
        } else
            return false;
    }

}
