<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Home 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_homeController
 *
 * */
class Commerce_homeController extends Brightery_Controller {

    protected $layout = 'commerce';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_categories");
    }

    public function indexAction() {
        $categories = new \modules\commerce\models\Commerce_categories();
        $products = new \modules\commerce\models\Commerce_products();
        $categories->_select = "commerce_category_id, parent, title";
        $categories->parent = 0;
        $categories->featrued = 'yes';

        $recent_products = $this->Database->query("SELECT commerce_products.*,`commerce_categories`.`title` " //,`commerce_categories`.`description` as category_desc "
                        . "FROM `commerce_products` "
                        . "JOIN `commerce_categories` ON `commerce_categories`.`commerce_category_id`=`commerce_products`.`commerce_category_id` "
                        . "ORDER BY commerce_products.commerce_product_id DESC LIMIT 20")->result();

        $offers = new \modules\commerce\models\Commerce_products_offers();
        $offers->_select = "commerce_products_offer_id, title, commerce_product_id, offer_image";

        return $this->render('commerce_home', [
                    'categories' => $categories->get(),
                    'category_model' => $categories,
                    'offers' => $offers->get(),
                    'product_model' => $products,
                    'recent_products' => $recent_products
        ]);
    }

}
