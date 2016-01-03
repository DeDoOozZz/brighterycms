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
class Brightery_licensesController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction($offset=0) {
        $this->permission('index');
        $this->load->library('pagination');
        $this->language->load("license");
        $model = new \modules\brightery\models\Brightery_licenses();
        if ($this->input->post('license_code_search'))
            $r[] = '`brightery_licenses`.`license_code`="' . $this->input->post('license_code_search') . '"';

        if ($this->input->post('domain_search'))
            $r[] = 'brightery_licenses.domain="' . $this->input->post('domain_search') . '"';

        $product_name = Form_helper::queryToDropdown('brightery_products', 'brightery_product_id', 'title');

        if ($this->input->post('brightery_product_id'))
            $r[] = '`brightery_products`.`brightery_product_id` ="' . $this->input->post('brightery_product_id') . '"';
        if ($this->input->post('user'))
            $r[] = ' fullname LIKE ' . '%' . $this->input->post('user') . '% ' . ' or email LIKE ' . '%' . $this->input->post('user') . '% ' . 'or `phone` LIKE ' . '%' . $this->input->post('user') . ' %';


        foreach ($r as $key => $value) {
            if ($key == 0) {
                $r[$key] = ' where ' . $value;
            } else {
                $r[$key] = ' and ' . $value;
            }
        }


        $res = $this->database->query("select 
  license_code,
  brightery_licenses.brightery_license_id,
  title,
  domain 
from `brightery_licenses` 
join `brightery_products` on `brightery_products`.`brightery_product_id` = `brightery_licenses`.`brightery_product_id` 
join `users` on `users`.`user_id`=`brightery_licenses`.`user_id`
 join `user_phones` On `users`.`user_id`=`user_phones`.`user_id`
" . implode($r) . "
group by license_code
")->result();

        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/brightery_licenses/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];

        return $this->render('license/index', [
                    'items' => $res,
                    'product_name' => $product_name,
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $this->language->load("license");
        if ($id)
            $model = new Brightery_licenses('edit');
        else
            $model = new Brightery_licenses('add');
        $product = Form_helper::queryToDropdown('brightery_products', 'brightery_product_id', 'title');
        $user = Form_helper::queryToDropdown('users', 'user_id', 'fullname');
        $payment_type;
        if ($this->input->post('payment_type') == 'fixed') {
            $payment_type = 'fixed';
            $brightery_products_subscription_id = null;
        } else {
            $payment_type = 'subscription';
            $brightery_products_subscription_id = $this->input->post('subscription_status');
        }



        if ($_POST) {
            $model->attributes = [
                'license_code' => $this->input->post('license_code'),
                'brightery_product_id' => $this->input->post('brightery_product_id'),
                'domain' => $this->input->post('domain'),
                'user_id' => $this->input->post('user_id'),
                'payment_type' => $payment_type,
            ];
            if ($brightery_products_subscription_id)
                $model->attributes['brightery_products_subscription_id'] = $brightery_products_subscription_id;
        }
        if ($id)
            $model->brightery_license_id = $id;

        if ($r = $model->save()) {
            if ($id) {
                echo $id;
                Uri_helper::redirect("management/brightery_licenses");
            } else {
                $model11 = new \modules\brightery\models\brightery_invoices(FALSE);
                $model11->attributes = [
                    'brightery_license_id' => $r,
                    'due_date' => date('Y-m-d'),
                    'status' => 'due'
                ];
                if ($model11->save()) {
                    Uri_helper::redirect("management/brightery_licenses");
                }
            }
        }
        return $this->render('license/manage', [
                    'item' => $model->get(),
                    'product' => $product,
                    'user' => $user
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            Brightery::error404("The page you requested is not found.");
        }
        $model = new Brightery_licenses();
        $model->brightery_license_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/brightery_licenses");
    }

    public function selectAction() {

        $this->layout = 'ajax';


        if ($this->input->post('id')) {

            $model = new \modules\brightery\models\brightery_products();
            $model->brightery_product_id = $this->input->post('id');
            $data = $model->get();

            echo "<option value=\"\">Select ...</option>";
            echo '<option value="FREE">FREE</option>';
            if ($data->fixed_price_status == 1) {


                echo '<option value="fixed">Fixed</option>';
            }
            if ($data->subscription_price_status == 1) {

                echo '<option value=' . $this->input->post('id') . '>Subscription</option>';
            }
        } else if ($this->input->post('type_id')) {
            echo $this->input->post('type_id');

            $model1 = new \modules\brightery\models\brightery_products_subscriptions();
            $model1->brightery_product_id = $this->input->post('type_id');
            $data = $model1->get();
            echo "<option value=\"\">Select ...</option>";
            foreach ($data as $value) {
                echo '<option value=' . $value->brightery_products_subscription_id . '>' . $value->period . '  ' . $value->period_cycle . '  ' . $value->price . ' $</option>';
            }
        }
    }

}
