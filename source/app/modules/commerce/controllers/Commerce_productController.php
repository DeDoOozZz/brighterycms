<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Product
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_productController
 *
 * */
class Commerce_productController extends Brightery_Controller {

    protected $layout = 'commerce';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_products");
    }

    public function indexAction($id) {
        $products = new \modules\commerce\models\Commerce_products();
        $categories = new \modules\commerce\models\Commerce_categories();
        $product_imgs = new \modules\commerce\models\Commerce_product_images();
        $product_imgs->commerce_product_id = $id;

        $info = $this->Database->query("SELECT commerce_products.*,`commerce_categories`.`title`,`commerce_categories`.`description` as category_desc, `commerce_brands`.`name` as brand, `commerce_brands`.`image` as brand_iamge "
                        . "FROM `commerce_products` "
                        . "JOIN `commerce_categories` ON `commerce_categories`.`commerce_category_id`=`commerce_products`.`commerce_category_id`"
                        . "LEFT JOIN `commerce_brands` ON `commerce_brands`.`commerce_brand_id`=`commerce_products`.`commerce_brand_id`"
                        . "WHERE commerce_products.commerce_product_id='$id'")->row();

        $main_category = $categories->getMainCategory($info->commerce_category_id);

        $related_products = $this->Database->query("SELECT commerce_products.*,`commerce_categories`.`title`,`commerce_categories`.`description` as category_desc "
                        . "FROM `commerce_products` "
                        . "JOIN `commerce_categories` ON `commerce_categories`.`commerce_category_id`=`commerce_products`.`commerce_category_id` "
                        . "WHERE commerce_products.commerce_product_id != '$id' "
                        . "AND commerce_categories.commerce_category_id = '" . $info->commerce_category_id . "' "
                        . "ORDER BY rand() LIMIT 3")->result();

        return $this->render('commerce_product', [
                    'item' => $info,
                    'categories' => $categories->get(),
                    'imgs' => $product_imgs->get(),
                    'product' => $products,
                    'main_cat' => $main_category,
                    'category_model' => $categories,
                    'product_model' => $products,
                    'related_products' => $related_products,
        ]);
    }

}
