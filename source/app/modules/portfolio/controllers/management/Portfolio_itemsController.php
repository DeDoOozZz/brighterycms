<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Portfolio_items 
 * @package Brightery CMS
 * @author 
 * @version 1.0
 *
 * @interface management
 * @module portfolio
 * @category general
 * @module_version  1.0
 *
 * @link http://store.brightery.com/module/general/portfolio
 * @controller Portfolio_itemsController
 * */
class Portfolio_itemsController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('portfolio');
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $model = new \modules\portfolio\models\Portfolio();
        $model->_select = "portfolio_id,portfolio_category_id,language_id,title,seo,image,description,created";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/Portfolio_items/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('portfolio_items/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        if ($id)
            $model = new \modules\portfolio\models\Portfolio('edit');
        else
            $model = new \modules\portfolio\models\Portfolio('add');
        $model->attributes = $this->Input->post();

        $model->language_id = $this->language->getDefaultLanguage();

        if (!$id)
            $model->created = date("Y-m-d H:i:s");
        if ($id)
            $model->portfolio_id = $id;
        $blog_category = Form_helper::queryToDropdown('portfolio_categories', 'portfolio_category_id', 'title');

        if ($model->save()) {
            Uri_helper::redirect("management/portfolio_items");
        }
        return $this->render('portfolio_items/manage', [
                    'item' => $id ? $model->get() : null,
                    'blog_category' => $blog_category
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\portfolio\models\Portfolio();
        $model->portfolio_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/portfolio_items");
    }

}
