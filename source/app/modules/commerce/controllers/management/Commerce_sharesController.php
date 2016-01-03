<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Sharing 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_sharesController
 *
 * */
class Commerce_sharesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_shares");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $commerce = new \modules\commerce\models\Commerce_shares();

        $commerce->_select = "`commerce_shares`.*, `users`.`fullname` ";
        $commerce->_joins = [
            'users' => ['`users`.`user_id`=`commerce_shares`.`user_id`', 'INNER']
        ];

        $this->load->library('pagination');
        $commerce->_limit = $this->config->get('limit');
        $commerce->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/commerce_shares/index'),
            'total' => $commerce->get(true),
            'limit' => $commerce->_limit,
            'offset' => $commerce->_offset
        ];

        return $this->render('commerce_shares/index', [
                    'items' => $commerce->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        if ($id)
            $commerce = new \modules\commerce\models\Commerce_shares('edit');
        else
            $commerce = new \modules\commerce\models\Commerce_shares('add');
        $commerce->attributes = $this->Input->input['post'];
        if ($id)
            $commerce->commerce_shares_id = $id;
        $commerce->language_id = $this->language->getDefaultLanguage();

        $user = Form_helper::queryToDropdown('users', 'user_id', 'fullname');

        if ($commerce->save())
            Uri_helper::redirect("management/commerce_shares");
        else
            return $this->render('commerce_shares/manage', [
                        'item' => $id ? $commerce->get() : null,
                        'user' => $user
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce = new \modules\commerce\models\Commerce_shares();
        $commerce->commerce_shares_id = $id;
        if ($commerce->delete())
            Uri_helper::redirect("management/commerce_shares");
    }

}
