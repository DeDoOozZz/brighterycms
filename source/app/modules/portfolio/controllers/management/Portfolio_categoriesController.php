<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Portfolio Categories 
 * 
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module portfolio
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/Portfolio_categories
 * @controller Portfolio_categoriesController
 * */
class Portfolio_categoriesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('portfolio_categories');
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $model = new \modules\portfolio\models\Portfolio_categories();
        $model->_select = "portfolio_category_id,language_id,title,seo,description,created";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/Portfolio_categories/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('portfolio_categories/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $model = new \modules\portfolio\models\Portfolio_categories();
        $model->attributes = $this->Input->post();

        $model->language_id = $this->language->getDefaultLanguage();

        if (!$id)
            $model->created = date("Y-m-d H:i:s");
        if ($id)
            $model->portfolio_category_id = $id;

        if ($model->save()) {
            Uri_helper::redirect("management/portfolio_categories");
        }
        return $this->render('portfolio_categories/manage', [
                    'item' => $id ? $model->get() : null
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\portfolio\models\Portfolio_categories();
        $model->portfolio_category_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/portfolio_categories");
    }

}
