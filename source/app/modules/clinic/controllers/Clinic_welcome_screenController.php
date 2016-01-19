<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clinic_welcome_screenController
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * @interface frontend
 * @module clinic
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/Clinic
 * @controller Clinic_welcome_screen
 * */
class Clinic_welcome_screenController extends Brightery_Controller
{
    protected $layout = 'ajax';

    public function indexAction($doctor_id)
    {
        $date = date("Y-m-d");

        $this->database->query("SET @x := 0;")->update();
        $this->database->query("UPDATE clinic_reservations SET `number` = (@x:=@x+1) where `clinic_reservations`.`clinic_doctor_id` = '$doctor_id' AND `date` = '$date' AND `status` != 'canceled'  ORDER BY `time`")->update();

        // GETTING RESERVATIONS
        $model = new \modules\clinic\models\Clinic_reservations();
        $model->_select = "user_id , `number`, time , status, (SELECT fullname FROM users WHERE users.user_id = clinic_reservations.user_id) as name";
        $model->date = $date;
        $model->clinic_doctor_id = $doctor_id;
        $model->clinic_reservation_status = 'confirmed';
        $model->where("`status` != 'late' AND `status` != 'canceled' AND `status` != 'entered' ");
        $model->_order_by['number'] = 'ASC';
        $queue = $model->get();

        // GETTING LATE RESERVATIONS
        $model_late = new \modules\clinic\models\Clinic_reservations();
        $model_late->_select = "user_id, `number`, time , status, (SELECT fullname FROM users WHERE users.user_id = clinic_reservations.user_id) as name";
        $model_late->clinic_doctor_id = $doctor_id;
        $model_late->date = $date;
        $model_late->clinic_reservation_status = 'confirmed';
        $model_late->_order_by['number'] = 'ASC';
        $model_late->status = 'late';
        $late = $model_late->get();

        // GETTING TIME FROM DOCTOR SCHEDULE 
        $model_time = new \modules\clinic\models\Clinic_schedules();
        $model_time->_select = "from_time , to_time ";
        $model_time->clinic_doctor_id = $doctor_id ;
        $model_time->day = date('l') ;
        $time = $model_time->get();
        $from_time = $time[0]->from_time;
        $to_time = $time[0]->to_time;
        

        return $this->render('clinic_welcome_screen/index', [
            'from_time' => $from_time,
            'to_time' => $to_time,
            'day' => $date,
            'names' => $queue,
            'late' => $late,
            'doctor_id' => $doctor_id,
            'assets_url' => BASE_URL . 'source/app/modules/clinic/assets/'
        ]);
    }

    public function cancelAction()
    {
        $user_id = $this->input->post('user_id');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $clinic_schedule_id = $this->input->post('clinic_schedule_id');
        $model = new \modules\clinic\models\Clinic_reservations(FALSE);
        $model->_select = "clinic_reservation_id";
        $model->user_id = $user_id;
        $model->date = $date;
        $model->time = $time;
        $model->clinic_reservation_status = 'confirmed';
        $result = $model->get();
        if ($model->get()) {
            $clinic_reservation_id = $result[0]->clinic_reservation_id;
            $model->clinic_reservation_id = $clinic_reservation_id;
            $model->status = 'canceled';
            if ($model->save(TRUE)) {
                $this->database->query("SET @x := 0;")->update();
                $this->database->query("UPDATE clinic_reservations SET `number` = (@x:=@x+1) where `clinic_schedule_id` = '$clinic_schedule_id' AND `date` = '$date' AND `status` != 'canceled'  ORDER BY `time`")->update();
                return true;
            } else
                return false;
        } else
            return false;
    }

    public function lateAction()
    {
        print_r($_POST);
        $user_id = $this->input->post('user_id');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $model = new \modules\clinic\models\Clinic_reservations(FALSE);
        $model->_select = "clinic_reservation_id";
        $model->user_id = $user_id;
        $model->date = $date;
        $model->time = $time;
        $model->clinic_reservation_status = 'confirmed';
        $result = $model->get();
        print_r($result);
        if ($result) {
            $clinic_reservation_id = $result[0]->clinic_reservation_id;
            $model->clinic_reservation_id = $clinic_reservation_id;
            $model->status = 'late';
            if ($model->save(TRUE))
                return true;
            else
                return false;
        } else
            return false;
    }

    public function enterAction()
    {
        $user_id = $this->input->post('user_id');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $model = new \modules\clinic\models\Clinic_reservations(FALSE);
        $model->_select = "clinic_reservation_id";
        $model->user_id = $user_id;
        $model->date = $date;
        $model->time = $time;
        $model->clinic_reservation_status = 'confirmed';
        $result = $model->get();
        if ($model->get()) {
            $clinic_reservation_id = $result[0]->clinic_reservation_id;
            $model->clinic_reservation_id = $clinic_reservation_id;
            $model->status = 'entered';
            if ($model->save(TRUE))
                return true;
            else
                return false;
        } else
            return false;
    }

    public function attendAction()
    {
        $user_id = $this->input->post('user_id');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $model = new \modules\clinic\models\Clinic_reservations(FALSE);
        $model->_select = "clinic_reservation_id";
        $model->user_id = $user_id;
        $model->date = $date;
        $model->time = $time;
        $model->clinic_reservation_status = 'confirmed';
        $result = $model->get();
        if ($model->get()) {
            $clinic_reservation_id = $result[0]->clinic_reservation_id;
            $model->clinic_reservation_id = $clinic_reservation_id;
            $model->status = 'attend';
            if ($model->save(TRUE))
                return true;
            else
                return false;
        } else
            return false;
    }

}
