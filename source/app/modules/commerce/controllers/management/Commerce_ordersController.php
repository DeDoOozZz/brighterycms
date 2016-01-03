<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Orders
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_ordersController
 * */
class Commerce_ordersController extends Brightery_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_orders");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $commerce_orders = new \modules\commerce\models\Commerce_orders();

        $commerce_orders->_select = "`commerce_orders`.*, `users`.`fullname`";
        $commerce_orders->_joins = [
            'users' => ['users.user_id = commerce_orders.user_id']
        ];
        $commerce_orders->_limit = $this->config->get('limit');
        $commerce_orders->_offset = $offset;

        $users = Form_helper::queryToDropdown('users', 'user_id', 'fullname');

        return $this->render('commerce_orders/index', [
                    'items' => $commerce_orders->get(),
                    'users' => $users,
                    'pagination' => $this->Pagination->generate([
                        'url' => Uri_helper::url('management/commerce_orders/index'),
                        'total' => $commerce_orders->get(true),
                        'limit' => $commerce_orders->_limit,
                        'offset' => $commerce_orders->_offset
                            ]
                    )
        ]);
    }

    public function viewAction($id = false)
    {
        if (!$id)
            return Brightery::error404();

        $orders = new \modules\commerce\models\Commerce_orders();

        $orders->_select = "`commerce_orders`.*, `users`.`fullname`";
        $orders->_joins = [
            'users' => ['users.user_id = commerce_orders.user_id']
        ];
        $orders->commerce_order_id = $id;

    }

    public function manageAction($id = false)
    {
        if ($id) {
            $this->permission('edit');
        } else {
            $this->permission('add');
        }
        $commerce_orders = new \modules\commerce\models\Commerce_orders();
        if ($_POST)
            $commerce_orders->attributes = ['subtotal' => $this->input->post('subtotal'), 'total' => $this->input->post('total'), 'commerce_payment_method_id' => $this->input->post('commerce_payment_method_id'), 'user_id' => $this->input->post('user_id'), 'billing_address' => $this->input->post('billing_address'), 'shipping_address' => $this->input->post('shipping_address'),];;
        if ($id)
            $commerce_orders->commerce_order_id = $id;

        if (!$id)
            $commerce_orders->created = date("Y-m-d H:i:s");

        $users = Form_helper::queryToDropdown('users', 'user_id', 'fullname');
        $paymet_method = Form_helper::queryToDropdown('commerce_payment_method', 'commerce_payment_method_id', 'name');

        if ($commerce_orders->save())
            Uri_helper::redirect("management/commerce_orders");
        else
            return $this->render('commerce_orders/manage', [
                'item' => $commerce_orders->get(),
                'users' => $users,
                'payment_method' => $paymet_method
            ]);
    }

    public function deleteAction($id = false)
    {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce_orders = new \modules\commerce\models\Commerce_orders();
        $commerce_orders->commerce_order_id = $id;
        if ($commerce_orders->delete())
            Uri_helper::redirect("management/commerce_orders");
    }

}
