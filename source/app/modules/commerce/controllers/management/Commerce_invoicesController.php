<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Invoices 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_invoicesController
 * */
class Commerce_invoicesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_invoices");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
    
        $commerce_invoices = new \modules\commerce\models\Commerce_invoices();
        $commerce_invoices->_select = "`commerce_invoices`.*,`commerce_orders`.`total`,`commerce_orders`.`created`, `users`.`fullname`";
        
        $commerce_invoices->_joins = [
            'commerce_orders'=> ['commerce_orders.commerce_order_id=commerce_invoices.commerce_order_id'],
            'users' => ['users.user_id=commerce_orders.user_id']
        ];
        
        $commerce_invoices->_limit = $this->config->get('limit');
        $commerce_invoices->_offset = $offset;

        return $this->render('commerce_invoices/index', [
                    'items' => $commerce_invoices->get(),
                    'pagination' => $this->Pagination->generate([
                        'url' => Uri_helper::url('management/commerce_invoices/index'),
                        'total' => $commerce_invoices->get(true),
                        'limit' => $commerce_invoices->_limit,
                        'offset' => $commerce_invoices->_offset
                        ]
                    )
        ]);
    }


}
