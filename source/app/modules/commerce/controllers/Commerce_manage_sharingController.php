<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Manage Sharing
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_manage_sharingController
 *
 * */
class Commerce_manage_sharingController extends Brightery_Controller {

    protected $layout = 'commerce';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_shares");
    }

    public function indexAction() {
        $userInfo = $this->permissions->getUserInformation();
        if( !$userInfo)
            Uri_helper::redirect("users");
        $commerce = new \modules\commerce\models\Commerce_shares('frontend_add');
        $commerce->attributes = $this->Input->input['post'];
        $commerce->user_id = $userInfo->user_id;
        if ($commerce->save())
            Uri_helper::redirect("commerce_sharing");
        else
            return $this->render('commerce_manage_sharing', [
                        'item' => $commerce->get(),
            ]);
    }

}
