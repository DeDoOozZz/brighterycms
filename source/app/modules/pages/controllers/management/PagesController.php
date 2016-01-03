<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pages Controller
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module pages
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pages
 *
 * */
class PagesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("pages");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $model = new \modules\pages\models\Pages();
        $model->_select = "page_id,language_id,title,seo,content,created,visibility_status_id";

        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/Pages/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('pages/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        if ($id)
            $model = new \modules\pages\models\Pages('edit');
        else
            $model = new \modules\pages\models\Pages('add');

        $model->attributes = $this->input->post();

        if (!$id)
            $model->created = date("Y-m-d H:i:s");
        if ($id)
            $model->page_id = $id;

        $model->visibility_status_menu = Form_helper::queryToDropdown('visibility_status', 'visibility_status_id', 'name');

        if ($model->save()) {
            Uri_helper::redirect("management/pages");
        }
        return $this->render('pages/manage', [
                    'item' => $id ? $model->get() : null,
                    'visibility_status_menu' => $model->visibility_status_menu
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\pages\models\Pages();
        $model->page_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/pages");
    }

}
