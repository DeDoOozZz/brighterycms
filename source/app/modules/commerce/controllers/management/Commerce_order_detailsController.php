<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Order Details 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_order_detailsController
 * */
class Commerce_order_detailsController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_order_details");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $commerce_order_details = new \modules\commerce\models\Commerce_order_details();

        $commerce_order_details->_select = "commerce_order_detail_id, option, qty, weight, commerce_product_id, price, product_total";
        $commerce_order_details->_limit = $this->config->get('limit');
        $commerce_order_details->_offset = $offset;

        return $this->render('commerce_order_details/index', [
                    'items' => $commerce_order_details->get(),
                    'pagination' => $this->Pagination->generate([
                        'url' => Uri_helper::url('management/commerce_order_details/index'),
                        'total' => $commerce_order_details->get(true),
                        'limit' => $commerce_order_details->_limit,
                        'offset' => $commerce_order_details->_offset
                            ]
                    )
        ]);
    }

    public function manageAction($id = false) {
        if ($id) {
            $this->permission('edit');
        } else {
            $this->permission('add');
        }
        $commerce_order_details = new \modules\commerce\models\Commerce_order_details();
        if ($_POST)
            $commerce_order_details->attributes = ['option' => $this->input->post('option'), 'qty' => $this->input->post('qty'), 'weight' => $this->input->post('weight'), 'commerce_product_id' => $this->input->post('commerce_product_id'), 'price' => $this->input->post('price'), 'product_total' => $this->input->post('product_total'),];;
        if ($id)
            $commerce_order_details->commerce_order_detail_id = $id;


        //$users = Form_helper::queryToDropdown('users', 'user_id', 'title', null, 'WHERE status != "active"');

        if ($commerce_order_details->save())
            Uri_helper::redirect("management/commerce_order_details");
        else
            return $this->render('commerce_order_details/manage', [
                        'item' => $id ? $commerce_order_details->get() : null,
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
           return Brightery::error404();
        }
        $commerce_order_details = new \modules\commerce\models\Commerce_order_details();
        $commerce_order_details->commerce_order_detail_id = $id;
        if ($commerce_order_details->delete())
            Uri_helper::redirect("management/commerce_order_details");
    }

}
