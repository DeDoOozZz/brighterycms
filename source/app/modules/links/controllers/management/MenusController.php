<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Menus
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module links
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/links
 * @controller MenusController
 *
 * */
class MenusController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("links");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $model = new \modules\links\models\Link_types();
        $model->_select = "link_type_id, name";

        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/menus/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('menus/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $model = new \modules\links\models\Link_types();
        $model->language_id = $this->language->getDefaultLanguage();
        $model->attributes = $this->Input->input['post'];
        if ($id)
            $model->link_type_id = $id;
        $model->language_id = $this->language->getDefaultLanguage();
        if (!$id)
            $model->created = date("Y-m-d H:i:s");
        if ($model->save())
            Uri_helper::redirect("management/menus");
        else
            return $this->render('menus/manage', [
                        'item' => $id ? $model->get() : null,
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\links\models\Link_types();
        $model->link_type_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/menus");
    }

}
