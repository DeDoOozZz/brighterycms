<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Wishlist
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_wishlistController
 *
 * */
class Commerce_wishlistController extends Brightery_Controller
{

    protected $layout = 'commerce';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_wishlist");
    }

    public function indexAction()
    {
        $this->permission('index');
        $userInfo = $this->permissions->getUserInformation();
        $commerce_wishlist = new \modules\commerce\models\Commerce_wishlist();
        $info = $this->Database->query("SELECT commerce_wishlist.*, `commerce_products`.* "
            . "FROM `commerce_wishlist` "
            . "JOIN `commerce_products` ON `commerce_products`.`commerce_product_id`=`commerce_wishlist`.`commerce_product_id`"
            . "")->result();

        $commerce_wishlist->user_id = $userInfo->user_id;
        return $this->render('commerce_wishlist', [
            'items' => $info,
            'product_model' => new \modules\commerce\models\Commerce_products()
        ]);
    }

    public function removeAction($id = false)
    {
        if (!$id)
            return Brightery::error404();

        $commerce_wishlist = new \modules\commerce\models\Commerce_wishlist();
        $commerce_wishlist->commerce_wishlist_id = $id;
        $commerce_wishlist->delete();
        Uri_helper::redirect("commerce_wishlist");
    }


    public function to_cartAction($id = false)
    {
        if (!$id)
            return Brightery::error404();
        $commerce_wishlist = new \modules\commerce\models\Commerce_wishlist();
        $commerce_wishlist->commerce_wishlist_id = $id;
        $product_id = $commerce_wishlist->get()->commerce_product_id;
        $commerce_wishlist->delete();
        $this->cart->add($product_id);
        Uri_helper::redirect("commerce_wishlist");
    }

    public function addAction($id = false)
    {
        if (!$id)
            return Brightery::error404();
        $this->layout = 'ajax';
        $userInfo = $this->permissions->getUserInformation();
        $this->database->insert('commerce_wishlist', [
            'commerce_product_id' => $id,
            'user_id' => $userInfo->user_id
        ]);
        return json_encode(['sucess' => 1]);
    }

}
