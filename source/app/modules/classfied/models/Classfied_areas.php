<?php

namespace modules\classfied\models;

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied areas Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Classfied_areas extends \Model {

    public $_table = 'classfied_areas';
    public $_fields = array(
        'classfied_area_id' => array('int', 11, 'PRI'),
        'name' => array('varchar', 255),
        'classfied_city_id' => array('int', 11),
    );

    public function rules() {
        return array(
            'all' => array(
                'name' => array('required'),
            ),
        );
    }

    public function fields() {
        return array(
            'name' => 'name',
            'classfied_city_id' => 'classfied city id',
        );
    }

}
