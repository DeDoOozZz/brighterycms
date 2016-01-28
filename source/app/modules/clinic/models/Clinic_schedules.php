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

    function get_newDate($date = NULL , $doctor_id) {
        $date_new = [];
        if ($date)
            $new_date = $date;
        elseif ($this->youm)
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
        $model_schedule = new Clinic_schedules();
        $model_schedule->_select = 'day , status';
        $model_schedule->clinic_doctor_id = $doctor_id;
        $model_schedule->status = 'on';
        $result = $model_schedule->get();
        foreach ($result as $value)
        {
            foreach ($date_new as $key => $date){
                if($date->day == $value->day)
                    $date_new[$key]->day_status = 'on';
            }
                
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
        $model_schedule->_select = 'day , from_time , to_time , status';
        $model_schedule->clinic_doctor_id = $doctor_id;
//        $model_schedule->status = 'on';
        $res = $model_schedule->get();
        foreach ($date as $key => $value) {
            $day = $date[$key]->day;
            $d = $date[$key]->date;
            foreach ($i as $k => $v) {
                $i[$k]->schedule->$day->date = $d;
                $i[$k]->schedule->$day->day = $day;
                $i[$k]->schedule->$day->status = '';
                $i[$k]->schedule->$day->from_time = '';
                $i[$k]->schedule->$day->to_time = '';
                foreach ($res as $value) {
                    if ($day == $value->day && $value->status == 'on')
                        $i[$k]->schedule->$day->day_status = 'on';
                }
                foreach ($res as $tare) {
                    if ($tare->day == $day) {
                        $tare->date = $d;
//                        if($tare->status == 'on')
//                            $tare->
                    }
                }
            }
        }
        $count = 0;
        foreach ($res as $keyy => $value) {
            /////////////////////////////Clinic Reservations///////////////////////////
            $model_reservations = new Clinic_reservations();
            $model_reservations->_select = 'clinic_reservation_id, user_id , date , time ';
            $model_reservations->date = $res[$keyy]->date;
            $model_reservations->clinic_doctor_id = $doctor_id;
            $dates = $model_reservations->get();

            if ($dates) {
                foreach ($dates as $key => $value) {
                    foreach ($date_new as $keyy => $valuee) {
                        if ($date_new[$keyy]->date == $dates[$key]->date) {
                            $time = $dates[$key]->time;
                            $date = $dates[$key]->date;
                            $user_id = $dates[$key]->user_id;
                            /////////////////////get day////////////////////////////////////////
                            $timestamp = strtotime($date);
                            $day = date("l", $timestamp);
                            //////////////////////get full name from users//////////////////////
                            $user = new \modules\users\models\Users();
                            $user->_select = 'fullname';
                            $user->user_id = $user_id;
                            $user->status = 'active';
                            $res_name = $user->get();
                            $fullname = $res_name->fullname;

                            //////////////////insert in array///////////////////////////////////
                            if (isset($i[$time]->schedule->{$day})) {
                                $test = $i[$time]->schedule->{$day};
                                $test->time = $time;
                                $test->day = $day;
                                $test->date = $date;
                                $test->fullname = $fullname;
                                $test->status = 'reserved';
                            }
                        }
                    }
                }
            }
        }
        Clinic_schedules::$result_final = $res;
        return $i;
    }

    function exceptions($doctor_id) {
        $res = Clinic_schedules::$result_final;
        foreach ($res as $key => $value) {
            $exceptions = new exceptions();
            $exception = new Clinic_schedule_exceptions();
            $exception->_select = 'date, from_time, to_time';
            $exception->clinic_doctor_id = $doctor_id;
            $res_exceptions = $exception->get();
            $date = $res_exceptions[$key]->date;
            $from_time = $res_exceptions[$key]->from_time;
            $to_time = $res_exceptions[$key]->to_time;

            /////////////////////get day////////////////////////////////////////
            $day_id = new Clinic_schedules();
            $day_id->_select = 'day';
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
                    break;
                }
            }
        }

        foreach ($date as $key => $value) {
            $day = $date[$key]->day;
            $d = $date[$key]->date;
            foreach ($reserved as $k => $v) {
                $reserved[$k]->schedule->$day->date = $d;
                $reserved[$k]->schedule->$day->day = $day;
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

    public function get_searchResult($date, $time, $doctor_id) {
        $i = 0;
        $x = 0;
//        $final_result = [];
//        $newtime[]->time = (object) array('time', 'user_id', 'date');
        foreach ($time as $key => $value) {
            $newtime[$key]->time = $value;
        }
        foreach ($newtime as $key => $value) {
            $model_rev = new \modules\clinic\models\Clinic_reservations();
            $model_rev->_select = 'user_id , date , time';
            $model_rev->time = $value->time;
            $model_rev->date = $date;
            $model_rev->clinic_doctor_id = $doctor_id;
            $model_rev->where = 'clinic_reservation_status = "confirmed" of clinic_reservation_status = "pending"';
            $result_f = $model_rev->get();
            $user_id = $result_f[0]->user_id;
            if ($result_f) {
                foreach ($result_f as $key => $value) {
                    $tim = $result_f[$key]->time;
                    foreach ($newtime as $k => $val) {
                        if ($newtime[$k]->time == $tim) {
                            $user_id = $result_f[$key]->user_id;
                            $newtime[$k]->user_id = $user_id;
                            $newtime[$k]->date = $date;
                            $newtime[$k]->time = $tim;
                            $newtime[$k]->status = 'reserved';
                        }
                    }
                }
            }
        }

        $model_ex = new \modules\clinic\models\Clinic_schedule_exceptions();
        $model_ex->select = '';
        $model_ex->clinic_doctor_id = $doctor_id;
        $model_ex->date = $date;
        $exception = $model_ex->get();

        foreach ($exception as $key => $v) {
            $ffff = strtotime("1970-01-01 $v->from_time UTC");
            $tttt = strtotime("1970-01-01 $v->to_time UTC");
            foreach ($newtime as $k => $value) {
                $newwww = $newtime[$k]->time;
                $convert = strtotime("1970-01-01 $newwww UTC");
                if ($convert == $ffff) {
                    $newtime[$k]->status = 'except';
                    $newtime[$k]->time = $newwww;
                } elseif ($convert == $tttt) {
                    $newtime[$k]->status = 'except';
                } elseif ($convert > $ffff && $convert < $tttt) {
                    $newtime[$k]->status = 'except';
                }
            }
        }
        return $newtime;
    }

}
