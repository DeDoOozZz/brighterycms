<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Dashboard 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_dashboardController
 *
 * */
class Commerce_dashboardController extends Brightery_Controller {

    protected $layout = 'commerce';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_dashboard");
    }

    public function indexAction() {

        $user = new \modules\users\models\Users();
        $user->user_id = $id;
        $user->_select = "user_id, fullname, email, password, image, gender, birthdate";

        return $this->render('commerce_dashboard/index', [
                    'item' => $user->get()
        ]);
    }

}
