<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Category
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_categoryController
 *
 * */
class Commerce_categoryController extends Brightery_Controller
{

    protected $layout = 'commerce';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_products");
    }

    public function indexAction($id)
    {
        $products = new \modules\commerce\models\Commerce_products();
        $category = new \modules\commerce\models\Commerce_categories();
        $category->commerce_category_id = $id;
        $products->commerce_category_id = $id;
        return $this->render('commerce_category', [
            'item' => $category->get(),
            'products' => $products->get(),
            'product_model' => $products,
        ]);
    }

}
