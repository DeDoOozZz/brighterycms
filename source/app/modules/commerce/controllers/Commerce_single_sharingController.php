<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce_single_sharing Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_single_sharing
 *
 * */
class Commerce_single_sharingController extends Brightery_Controller {

    protected $layout = 'commerce';

    public function indexAction($id) {

         $sharing = $this->Database->query("SELECT commerce_shares.*, `users`.`fullname` "
                        . "FROM `commerce_shares` "
                        . "JOIN `users` ON `users`.`user_id`=`commerce_shares`.`user_id`"
                        . "WHERE commerce_shares.commerce_shares_id='$id'")->row();
         
        return $this->render('commerce_single_sharing', [
                    'item' => $sharing
        ]);
    }

}
