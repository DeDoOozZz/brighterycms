<?php namespace modules\clinic\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * @module Clinic_reservations
 * @category general
 * @module_version 1.0

 * @link http://store.brightery.com/module/general/Clinic_reservations
 * @model Clinic_reservations
 * */
class Clinic_reservations extends \Model {

    public $_table = 'clinic_reservations';
    public $_fields = [
        'clinic_reservation_id' => ['int', 11, 'PRI'],
        'clinic_doctor_reservation_type_id' => ['int', 11],
        'clinic_doctor_id' => ['int', 11],
        'date' => ['date'],
        'time' => ['time'],
        'clinic_reservation_status' => ['enum'],
        'user_id' => ['int', 11],
        'created' => ['datetime'],
        'status' => ['enum'],
        'order' => ['int',11],
    ];

    public function rules() {
        return [
            'all' => [
                'clinic_doctor_id' => ['required', 'numeric'],
                'clinic_doctor_reservation_type_id' => ['required'],
                'date' => ['required'],
                'time' => ['required'],
                'clinic_reservation_status' => ['required'],
            ],
        ];
    }

    public function fields() {
        return [
            'clinic_doctor_id' => 'Doctor',
            'date' => 'Date',
            'time' => 'Time',
            'user_id' => 'User ID',
            'clinic_reservation_status' => 'Reservation Status',
            'created' => 'created',
        ];
    }

}
