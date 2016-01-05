<?php

namespace modules\clinic\models;

defined('ROOT') OR exit('No direct script access allowed');

/**
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * @module Clinic
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/Clinic_schedules
 * @model Clinic_schedules
 * */
//$res = (object)array();

class reserved {
    
}

class exceptions {

    public $day;
    public $date;
    public $from_time;
    public $to_time;

}

class Clinic_schedules extends \Model {

    public static $result_final;
    public $youm;
    public $_table = 'clinic_schedules';
    public $_fields = [
        'clinic_schedule_id' => ['int', 11, 'PRI'],
        'clinic_doctor_id' => ['int', 11],
        'day' => ['enum', ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']],
        'from_time' => ['time'],
        'to_time' => ['time'],
        'status' => ['enum', ['on', 'off']],
    ];

    public function rules() {
        return [
//            'all' => [
//                'clinic_doctor_id' => ['required', 'numeric'],
//                'day' => ['required'],
//                'from_time' => ['required'],
//                'to_time' => ['required'],
//            ],
        ];
    }

    public function fields() {
        return [
            'clinic_doctor_id' => 'clinic_doctor_id',
            'day' => 'day',
            'from_time' => 'from_time',
            'to_time' => 'to_time',
        ];
    }

    function get_time($from, $to, $period, $doctor_id) {
        $from_hr = substr($from, 0, 2);
        $from_mn = substr($from, 3, 2);
        $to_hr = substr($to, 0, 2);
        $to_mn = substr($to, 3, 2);
        $time = [];
        $x = $from_mn;
        $y = 0;
        for ($i = $from_hr; $i <= $to_hr; $i++) {
            for ($v = 0; $v <= 60; $v++) {
                $time[$y++] = $i . ':' . $x . ':00';
                if ($i == $to_hr && $x == $to_mn) {
                    $break = 1;
                    break;
                }
                $x = $x + $period;
                if ($x == 5 || $x == 4 || $x == 3 || $x == 2 || $x == 1)
                    $x = '0' . $x;
                if ($x == 60) {
                    $i++;
                    if ($i == '2' || $i == '3' || $i == '4' || $i == '5' || $i == '6' || $i == '7' || $i == '8' || $i == '9')
                        $i = '0' . $i;
                    $x = '00';
                } else if ($x > 60) {
                    $i++;
                    if ($i == '2' || $i == '3' || $i == '4' || $i == '5' || $i == '6' || $i == '7' || $i == '8' || $i == '9')
                        $i = '0' . $i;
                    $x = $x - 60;
                }
            }
            if ($break == 1)
                break;
            $x = 0;
        }
        return $time;
    }

    function get_newDate() {
        $date_new = [];
        if ($this->youm)
            $new_date = $this->youm;
        else
            $new_date = date("Y-m-d");
        $date_new[0]->date = $new_date;
        $date_new[0]->day = date_format(date_create($new_date), 'l');
        for ($x = 1; $x <= 6; $x++) {
            $date = strtotime("+1 day", strtotime($new_date));
            $new_date = date("Y-m-d", $date);
            $date_new[$x]->date = $new_date;
            $date_new[$x]->day = date_format(date_create($new_date), 'l');
        }
        return $date_new;
    }

    function get_schedule($datenew, $time, $doctor_id) {
        $i = [];
        $date = $datenew;
        $date_new = $this->get_newDate();
        foreach ($time as $key => $value) {
            $key = new reserved();
            $i[$value] = $key;
            $i[$value]->time = $value;
        }

        /////////////////////////////Clinic Schedules///////////////////////////
        $model_schedule = new Clinic_schedules();
//        $model_schedule->_select = 'clinic_schedule_id, day , from_time , to_time ';
        $model_schedule->_select = 'day , from_time , to_time ';
        $model_schedule->clinic_doctor_id = $doctor_id;
        $res = $model_schedule->get();
//        $res = Clinic_schedules::resultchange();
//        print_r($res);
//        exit();
        foreach ($date as $key => $value) {
            $day = $date[$key]->day;
            $d = $date[$key]->date;
            $id = $date[$key]->clinic_schedule_id;
            foreach ($i as $k => $v) {
                $i[$k]->schedule->$day->date = $d;
                $i[$k]->schedule->$day->day = $day;
//                $i[$k]->schedule->$day->clinic_schedule_id = $id;
                $i[$k]->schedule->$day->status = '';
                $i[$k]->schedule->$day->from_time = '';
                $i[$k]->schedule->$day->to_time = '';
                foreach ($res as $tare) {
                    if ($tare->day == $day) {
                        $tare->date = $d;
                    }
                }
            }
        }
//        print_r($res);
//        exit();
        $count = 0;
        foreach ($res as $keyy => $value) {

//            $clinic_schedule_id = $res[$keyy]->clinic_schedule_id;
            /////////////////////////////Clinic Reservations///////////////////////////
            $model_reservations = new Clinic_reservations();
            $model_reservations->_select = 'clinic_reservation_id, user_id , date , time ';
            $model_reservations->date = $res[$keyy]->date;
            $model_reservations->clinic_doctor_id = $doctor_id;
            $dates = $model_reservations->get();

            foreach ($dates as $key => $value) {
                print_r($dates);
//                exit();
                foreach ($date_new as $keyy => $valuee) {
//                    print_r($date_new);
//                    exit();
//                    exit();
//                    $i[$time]->schedule->clinic_schedule_id = $schedule_id;
                    if ($date_new[$keyy]->date == $dates[$key]->date) {
//                        echo $date_new[$keyy]->date;
//                        echo "==";
//                        echo $dates[$key]->date; 
//                        $schedule_id = $dates[$key]->clinic_schedule_id;
                        $time = $dates[$key]->time;
                        $date = $dates[$key]->date;
                        $user_id = $dates[$key]->user_id;

//                        $string = "2010-11-24";
//                        exit();
                        /////////////////////get day////////////////////////////////////////
                        $timestamp = strtotime($date);
                        $day = date("l", $timestamp);
//                        $day_id = new Clinic_schedules();
//                        $day_id->select = 'day';
////                        $day_id->clinic_schedule_id = $dates[$key]->clinic_schedule_id;
//                        $day_id->clinic_doctor_id = $dates[$key]->clinic_doctor_id;
//                        $res_day = $day_id->get();
//                        print_r($res_day);
//                        exit();
//                        echo $day = $res_day[$count++]->day;
//                        exit();
                        //////////////////////get full name from users//////////////////////
                        $user = new \modules\users\models\Users();
                        $user->_select = 'fullname';
                        $user->user_id = $user_id;
                        $user->status = 'active';
                        $res_name = $user->get();
                        $fullname = $res_name->fullname;

                        //////////////////insert in array///////////////////////////////////
//                        print_r($i[$time]->schedule->{$day}->status );
//                        exit();
                        if (isset($i[$time]->schedule->{$day})) {
                            $test = $i[$time]->schedule->{$day};
//                        print_r($test);

                            $test->time = $time;
                            $test->day = $day;
                            $test->date = $date;
                            $test->fullname = $fullname;
                            $test->status = 'reserved';
                        }
//                        print_r($i);
//                        exit();
//                        $i[$time]->schedule->{$day}->time = $time;
//                        $i[$time]->schedule->{$day}->day = $day;
//                        $i[$time]->schedule->{$day}->date = $date;
//                        $i[$time]->schedule->{$day}->fullname = $fullname;
//                        $i[$time]->schedule->{$day}->status = 'reserved';
                    }
                }
            }
        }
//        exit();
//        print_r($i);
//        exit();
        Clinic_schedules::$result_final = $res;
        return $i;
    }

    function exceptions($doctor_id) {
        /////////////////////////////Clinic Schedules///////////////////////////
//        $model_schedule = new Clinic_schedules();
//        $model_schedule->_select = 'day , from_time , to_time ';
////        $model_schedule->_select = 'clinic_schedule_id, day , from_time , to_time ';
//        $model_schedule->clinic_doctor_id = $doctor_id;
//        $res = $model_schedule->get();
//        print_r($res);
//        exit();
//        var_dump(Clinic_schedules::$res) ;
//        Clinic_schedules::$result_final ;
        $res = Clinic_schedules::$result_final;
        foreach ($res as $key => $value) {
            $exceptions = new exceptions();
            $exception = new Clinic_schedule_exceptions();
//            $exception->_select = 'clinic_schedule_id, date, from_time, to_time';
            $exception->_select = 'date, from_time, to_time';
//            $exception->clinic_schedule_id = $res[$key]->clinic_schedule_id;
            $exception->clinic_doctor_id = $doctor_id;
            $res_exceptions = $exception->get();
            $date = $res_exceptions[$key]->date;
            $from_time = $res_exceptions[$key]->from_time;
            $to_time = $res_exceptions[$key]->to_time;

            /////////////////////get day////////////////////////////////////////
            $day_id = new Clinic_schedules();
            $day_id->_select = 'day';
//            $day_id->clinic_schedule_id = $res[$key]->clinic_schedule_id;
            $res_day = $day_id->get();

            $day = $res_day[$key]->day;
            $exceptions->date = $date;
            $exceptions->day = $day;
            $exceptions->from_time = $from_time;
            $exceptions->to_time = $to_time;
            $except[$key] = $exceptions;
        }
        Clinic_schedules::$result_final = $res;
        return $except;
    }

    public function get_date($d) {
        $this->youm = $d;
    }

    public function Pre($a, $c, $t) {
        $reserved = $a;
        $date = $t;
        $result = $c;
        foreach ($result as $key => $value) {
            foreach ($date as $k => $v) {
                if ($result[$key]->day == $date[$k]->day) {
//                    $date[$k]->clinic_schedule_id = $result[$key]->clinic_schedule_id;
                    break;
                }
            }
        }

        foreach ($date as $key => $value) {
            $day = $date[$key]->day;
            $d = $date[$key]->date;
//            $id = $date[$key]->clinic_schedule_id;
            foreach ($reserved as $k => $v) {
                $reserved[$k]->schedule->$day->date = $d;
                $reserved[$k]->schedule->$day->day = $day;
//                $reserved[$k]->schedule->$day->clinic_schedule_id = $id;
                $reserved[$k]->schedule->$day->status;
            }
        }
        foreach ($result as $key => $value) {
            $day = $result[$key]->day;
            foreach ($reserved as $k => $v) {
                $reserved[$k]->schedule->$day->from_time = $result[$key]->from_time;
                $reserved[$k]->schedule->$day->to_time = $result[$key]->to_time;
            }
        }
        return $reserved;
    }

    public function Final_Array($res, $exc) {
        $reserved = $res;
        $except = $exc;
        foreach ($reserved as $key => $value) {
            foreach ($except as $k => $v) {
                $new_day = $except[$k]->day;
                if ($reserved[$key]->schedule->$new_day->date == $except[$k]->date && $key >= $except[$k]->from_time && $except[$k]->to_time >= $key)
                    $reserved[$key]->schedule->$new_day->status = 'except';
            }
        }
        $date[] = 'Saturday';
        $date[] = 'Sunday';
        $date[] = 'Monday';
        $date[] = 'Tuesday';
        $date[] = 'Wednesday';
        $date[] = 'Thursday';
        $date[] = 'Friday';
        $new_date = date("Y-m-d");
        $new_time = date("H:i:s");
        foreach ($reserved as $key => $value) {
            for ($i = 0; $i <= 6; $i++)
                if ($new_time >= $key && $reserved[$key]->schedule->$date[$i]->date == $new_date)
                    $reserved[$key]->schedule->$date[$i]->status = 'except';
        }
        return $reserved;
    }

}
