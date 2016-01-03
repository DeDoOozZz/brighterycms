<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Contact Us Controller
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module contact_us
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/contact_us
 * @controller Contactus
 *
 * */
class Brightery_invoicesController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction($id) {
        $this->permission('index');
      
        $this->language->load("invoices");
        $model = new modules\brightery\models\Brightery_invoices();
        $res = $this->database->query("select brightery_invoices.due_date,brightery_invoices.`status`,
            `brightery_licenses`.`brightery_license_id`
             from brightery_licenses join `brightery_invoices` 
             ON `brightery_licenses`.`brightery_license_id`=`brightery_invoices`.`brightery_license_id`
             where  `brightery_licenses`.`brightery_license_id`=" . $id. "")->result();

        return $this->render('invoices/index', [
                    'items' => $res,
        ]);
    }

}
