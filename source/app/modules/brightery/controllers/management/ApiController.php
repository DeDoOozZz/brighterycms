<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Contact Us Controller
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module brightery
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/contact_us
 * @controller Contactus
 *
 * */
class ApiController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'ajax';
    protected $auth = true;

    public function indexAction() {

//        echo $_post['username'] . '<br>';
//        echo $_post['password'] . '<br>';
//        echo $_post['code'] . '<br>';

       
        $model = new \modules\users\models\Users();
        $model->email = $_GET['username'];
        $model->password = $_GET['password'];

//        print_r($model->get()) . '<br>';
//        print_r($model->get());
        if ($data = $model->get()) {
            $model1 = new \modules\brightery\models\brightery_licenses();
            $model1->license_code = $_GET['code'];
            $model1->status = 'active';
            $model1->user_id = $data[0]->user_id;
            if ($data1 = $model1->get()) {

                $data1[0]->brightery_license_id;
                $res = $this->database->query('select max(due_date) from brightery_invoices 
                    where brightery_license_id=  ' . $data1[0]->brightery_license_id . '  
                    AND status= "paid"   
                     GROUP BY brightery_license_id  
                      HAVING max(due_date) <  now()')->result();

                if ($res) {
                    echo json_encode(['status' => 'success','code'=>  rand(0, 1000)]);
                }
            } else {

                echo json_encode(['status' => 'faild', 'message' => 'license not found']);
            }
        } else {
            echo json_encode(['status' => 'faild', 'message' => 'user not found']);
        }
        exit();
    }

}
