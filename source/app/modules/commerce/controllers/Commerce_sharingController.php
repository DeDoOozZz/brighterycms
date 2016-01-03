<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Sharing 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_sharingController
 *
 * */
class Commerce_sharingController extends Brightery_Controller {

    protected $layout = 'commerce';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_shares");
    }

    public function indexAction() {

        $sharing = $this->Database->query("SELECT commerce_shares.*, `users`.`fullname` "
                        . "FROM `commerce_shares` "
                        . "JOIN `users` ON `users`.`user_id`=`commerce_shares`.`user_id`"
                        . "")->result();
        return $this->render('commerce_sharing', [
                    'items' => $sharing
        ]);
    }

}
