<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clients
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module clients
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/clients
 * @controller ClientsController
 * */
class ClientsController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('clients');
    }

    public function indexAction() {
        $this->permission('index');
        $model = new \modules\clients\models\Clients();
        $model->_select = "client_id, name, image ";
        return $this->render('clients/index', [
                    'items' => $model->get()
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        if ($id)
            $model = new \modules\clients\models\Clients('edit');
        else
            $model = new \modules\clients\models\Clients('add');

        $model->attributes = $this->Input->post();
        if ($id)
            $model->client_id = $id;

        if ($model->save()) {
            Uri_helper::redirect("management/clients");
        }
        return $this->render('clients/manage', [
                    'item' => $id ? $model->get() : null
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\clients\models\Clients();
        $model->Client_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/clients");
    }

}
