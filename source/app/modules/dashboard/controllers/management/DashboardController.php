<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Dashboard
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module dashboard
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/dashboard
 * @controller DashboardController
 *
 * */
class DashboardController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('dashboard');
    }

    public function indexAction() {
        return $this->render('dashboard/index');
    }

}
