<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Cart
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_cartController
 * */
class Commerce_cartController extends Brightery_Controller {

    protected $layout = 'commerce';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_cart");
    }

    public function indexAction() {
        $info = $this->Database->query("SELECT commerce_products.*,`commerce_categories`.`title`"
                        . "FROM `commerce_products` "
                        . "JOIN `commerce_categories` ON `commerce_categories`.`commerce_category_id`=`commerce_products`.`commerce_category_id`"
                        . "")->row();
        return $this->render('commerce_cart', [
                    'items' => $this->cart->get(),
                    'cart' => $this->cart,
                    'product_model' => new \modules\commerce\models\Commerce_products(),
                    'category' => $info
        ]);
    }

    public function removeAction($id = false) {
        if (!$id)
            return Brightery::error404();
        $this->cart->remove($id);
        Uri_helper::redirect("commerce_cart");
    }

    public function updateAction($id = false, $qty = 1) {
        if (!$id)
            return Brightery::error404();
        $this->cart->update($id, $qty);
        Uri_helper::redirect("commerce_cart");
    }

    public function to_wishlistAction($id = false) {
        if (!$id)
            return Brightery::error404();
        $userInfo = $this->permissions->getUserInformation();
        $product_id = $this->cart->getProductId($id);
        $this->cart->remove($id);
        $this->database->insert('commerce_wishlist', [
            'commerce_product_id' => $product_id,
            'user_id' => $userInfo->user_id
        ]);
        Uri_helper::redirect("commerce_cart");
    }

    public function addAction($id = false) {
        if (!$id)
            return Brightery::error404();
        $this->layout = 'ajax';
        $this->cart->add($id);
        return json_encode(['total' => $this->cart->getItemsCount()]);
    }

}
