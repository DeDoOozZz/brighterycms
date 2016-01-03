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
class Brightery_productsController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $this->language->load("brightery");

        $model = new \modules\brightery\models\brightery_products();
        $model->_select = "brightery_product_id,title,fixed_price_status,fixed_price,subscription_price_status";
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/brightery_products/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('brightery/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        $status = 0;
        $subscription_status = 0;
        if ($this->input->post('fixed') == 1)
            $status = '1';
        if ($this->input->post('sfixedd') == 1)
            $subscription_status = '1';



        $this->language->load("brightery");
        if ($id) {
            $model = new \modules\brightery\models\Brightery_products('edit');
            $model1 = new Brightery_products_subscriptions('edit');
        } else {
            $model = new \modules\brightery\models\Brightery_products('add');
            $model1 = new Brightery_products_subscriptions('add');
        }

        if ($id) {


            $model->brightery_product_id = $id;
            $model1->brightery_product_id = $id;
            if ($_POST) {
                $model->attributes = [
                    'title' => $this->input->post('title'),
                    'fixed_price' => $this->input->post('fixed_price'),
                    'fixed_price_status' => $status,
                    'subscription_price_status' => $subscription_status
                ];

                $model->brightery_product_id = $id;
                $model1->brightery_product_id = $id;
                if ($model->save()) {



                    $model1 = new \modules\brightery\models\Brightery_products_subscriptions();


                    $model1->brightery_product_id = $r;
                    $model1->delete();

                    foreach ($this->input->post('n') as $key => $value) {

                        $model1->attributes = [
                            'brightery_product_id' => $r,
                            'period_cycle' => $this->input->post('s.' . $key),
                            'period' => $value,
                            'price' => $this->input->post('price.' . $key),
                        ];
                        $model1->save();
                    }
                    Uri_helper::redirect("management/brightery_products");
                }
            }



            return $this->render('brightery/manage', [
                        'item' => $model->get(),
                        'items' => $model1->get()
            ]);
        }

        if (!$id) {

            if ($_POST)
                $model->attributes = [
                    'title' => $this->input->post('title'),
                    'fixed_price' => $this->input->post('fixed_price'),
                    'fixed_price_status' => $status,
                    'subscription_price_status' => $subscription_status
                ];

            else {
                return $this->render('brightery/manage'
                );
            }
        }
        if ($r = $model->save()) {
            foreach ($this->input->post('n') as $key => $value) {

                $model1->attributes = [
                    'brightery_product_id' => $r,
                    'period_cycle' => $this->input->post('s.' . $key),
                    'period' => $value,
                    'price' => $this->input->post('price.' . $key),
                ];
                $model1->save();
            }
            Uri_helper::redirect("management/brightery_products");
        } else {
            foreach ($this->input->post('n') as $key => $value) {

                $data['items'][] = [
                    //   'title' => $this->input->post('title'),
                    //  'fixed_price' => $this->input->post('fixed_price'),
                    'count' => $key,
                    'period_cycle' => $this->input->post('s.' . $key),
                    'period' => $value,
                    'price' => $this->input->post('price.' . $key)
                ];
            }

            // $user = Form_helper::Dropdown('day', 'month', 'year');
            //   {{ helper.form.dropdown('brightery_product_id', user, helper.form.value('brightery_product_id', item.brightery_product_id), 'class="form-control select2"') }}

            return $this->render('brightery/manage', $data
            );
        }
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            Brightery::error404("The page you requested is not found.");
        }
        $model = new \modules\brightery\models\Brightery_products();
        $model1 = new \modules\brightery\models\ Brightery_products_subscriptions();


        $model->brightery_product_id = $id;
        $model1->brightery_product_id = $id;
        if ($model->delete() && $model1->delete()) {
            Uri_helper::redirect("management/brightery_products");
        }
    }

}
