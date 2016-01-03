<?php defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Orders
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce_
 * @controller Commerce_ordersController
 **/

class Commerce_ordersController extends Brightery_Controller
{

    protected $layout = 'commerce';
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_orders");
        $this->user = $this->permissions->getUserInformation();
        if (!$this->user)
            Uri_helper::redirect('users/register');
    }

    public function indexAction()
    {
        $order = new \modules\commerce\models\Commerce_orders('order');
        $order_details = new \modules\commerce\models\Commerce_order_details(false);
        $product = new \modules\commerce\models\Commerce_products(false);
        $invoice = new \modules\commerce\models\Commerce_invoices(false);

        $payment_method = Form_helper::queryToDropdown('commerce_payment_method', 'commerce_payment_method_id', 'name', false);
        $addresses = Form_helper::queryToDropdown('user_addresses', 'user_address_id', 'address', false, "WHERE user_id = " . $this->user->user_id);

        $order->set('subtotal', $this->cart->total());
        $order->set('total', $this->cart->total());
        $order->set('commerce_payment_method_id', $this->input->post('commerce_payment_method_id'));
        $order->set('user_id', $this->user->user_id);
        $order->set('billing_address', $addresses[$this->input->post('billing_address')]);
        $order->set('shipping_address', $addresses[$this->input->post('shipping_address')]);
        $order->set('status', $this->input->post('commerce_payment_method_id') == 2 ? 'confirmed' : 'pending');

        if ($order_id = $order->save()) {
            foreach($this->cart->get() as $item){
                $order_details->commerce_order_id = $order_id;
                $order_details->product_total = $product->discount($item->price, $item->discount) * $item->qty;
                $order_details->price = $product->discount($item->price, $item->discount);
                $order_details->commerce_product_id = $item->commerce_product_id;
                $order_details->weight = $item->weight;
                $order_details->qty = $item->qty;
                $order_details->save();
            }

            // INVOICE
            $invoice->commerce_order_id = $order_id;
            $invoice->status = 'pending';
            $invoice->save();

            if($this->input->post('commerce_payment_method_id') == '1') {
                $this->layout = 'ajax';
                return $this->render('payments/paypal', [
                    'total' => $this->cart->total()
                ]);
            }

            // THANK YOU FOR YOUR ORDER
            return $this->render('commerce_orders/commerce_order_confirmed');
        }
        else
            return $this->render('commerce_orders/commerce_make_order', [
                'user' => $this->user,
                'payment' => $payment_method,
                'addresses' => $addresses,
                'cart' => $this->cart
            ]);
    }

    public function my_ordersAction()
    {
        $commerce_orders = new \modules\commerce\models\Commerce_orders();
        $commerce_order_details = new \modules\commerce\models\Commerce_order_details();
        $orders_products = new \modules\commerce\models\Commerce_products();
        $commerce_orders->_select = "commerce_order_id, subtotal, total, commerce_payment_method_id, billing_address, shipping_address, created ";
        $commerce_orders->user_id = $this->user->user_id;
        $commerce_orders->status = 'confirmed';

        $payment_method = $this->Database->query("SELECT `commerce_payment_method`.`name`"
            . "FROM `commerce_orders` "
            . "JOIN `commerce_payment_method` ON `commerce_payment_method`.`commerce_payment_method_id`=`commerce_orders`.`commerce_payment_method_id`"
            . "")->row();

        return $this->render('commerce_orders/checkout', [
            'orders' => $commerce_orders->get(),
            'order_details' => $commerce_order_details,
            'products' => $orders_products,
            'payment' => $payment_method,
        ]);

    }

}
