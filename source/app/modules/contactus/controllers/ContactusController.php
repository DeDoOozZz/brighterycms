<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Contact Us Controller
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module contactus
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/contact_us
 * @controller ContactusController
 *
 * */
class ContactusController extends Brightery_Controller {

    protected $layout = 'classfied';

    public function __construct() {
        parent::__construct();
        $this->language->load('contactus');
    }

    public function indexAction() {
        $message = new \modules\contactus\models\Contactus();
        $message->attributes = [
            'name' => $this->Input->post('name'),
            'email' => $this->Input->post('email'),
            'message' => $this->Input->post('message'),
        ];

        $message->created = date("Y-m-d H:i:s");
        if ($message->save()) {
            $email_message = "Dear,\n"
                    . "Someone used your contact form and sent this message and details\n"
                    . "Name: " . $this->Input->post('name') . "\n"
                    . "Email: " . $this->Input->post('email') . "\n"
                    . "Message: " . $this->Input->post('message') . "\n"
                    . "----------------\n"
                    . "IP: " . $_SERVER['REMOTE_ADDR'];
            @mail('info@brightery.com', "Contact us form", $email_message);
        }
        return $this->render('contactus');
    }

}
