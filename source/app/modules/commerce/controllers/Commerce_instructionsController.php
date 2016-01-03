<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Instructions
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_instructionsController
 * */
class Commerce_how_workingController extends Brightery_Controller {

    protected $layout = 'commerce';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_instructions");
    }

    public function indexAction() {

        return $this->render('commerce_instructions');
    }

}
