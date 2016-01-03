<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Products Offers
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_products_offersController
 *
 * */
class Commerce_products_offersController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_products_offers");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $commerce = new \modules\commerce\models\Commerce_products_offers();

        $commerce->_select = "`commerce_products_offers`.*, `commerce_products`.`name`";
        $commerce->_joins = [
            'commerce_products' => ['`commerce_products`.`commerce_product_id`=`commerce_products_offers`.`commerce_product_id`', 'INNER']
        ];
        
        $this->load->library('pagination');
        $commerce->_limit = $this->config->get('limit');
        $commerce->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/commerce_products_offers/index'),
            'total' => $commerce->get(true),
            'limit' => $commerce->_limit,
            'offset' => $commerce->_offset
        ];

        return $this->render('commerce_products_offers/index', [
                    'items' => $commerce->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->auth = true;
        $this->permission('manage');
        if ($id)
            $commerce = new \modules\commerce\models\Commerce_products_offers('edit');
        else
            $commerce = new \modules\commerce\models\Commerce_products_offers('add');

        $commerce->attributes = $this->Input->input['post'];
        $products = Form_helper::queryToDropdown('commerce_products', 'commerce_product_id', 'name');

        if ($id)
            $commerce->commerce_products_offer_id = $id;

        $commerce->language_id = $this->language->getDefaultLanguage();


        if ($commerce->save())
            Uri_helper::redirect("management/commerce_products_offers");
        else
            return $this->render('commerce_products_offers/manage', [
                        'item' => $id ? $commerce->get() : null,
                        'products' => $products
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce = new \modules\commerce\models\Commerce_products_offers();
        $commerce->commerce_products_offer_id = $id;
        if ($commerce->delete())
            Uri_helper::redirect("management/commerce_products_offers");
    }

}
