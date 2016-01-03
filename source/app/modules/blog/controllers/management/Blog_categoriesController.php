<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Blog Categories
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module blog
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/blog
 * @controller Blog_categoriesController
 *
 * */
class Blog_categoriesController extends Brightery_Controller {

    public function __construct() {
        parent::__construct();
        $this->language->load("blog_categories");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $model = new \modules\blog\models\Blog_categories();
        $model->_offset = $offset;
        $model->_limit = $this->config->get('limit');
        $config = [
            'url' => Uri_helper::url('management/blog_categories/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];

        $model->language_id = $this->language->getDefaultLanguage();
        $model->_select = "blog_category_id, title, image, parent";
        return $this->render('blog_categories/index', [
        'items' => $model->get(),
        'category_model' => $model,
        'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        if ($id) {
            $model = new \modules\blog\models\Blog_categories('edit');
            $model->blog_category_id = $id;
        } else {
            $model = new \modules\blog\models\Blog_categories('add');
            $model->created = date("Y-m-d H:i:s");
        }
        $model->set('title', $this->Input->post('title'));
        $model->set('seo', $this->Input->post('seo'));
        $model->set('description', $this->Input->post('description'));
        $model->set('sort', $this->Input->post('sort'));
        $model->set('parent', $this->Input->post('parent'));

        $model->language_id = $this->language->getDefaultLanguage();
        $cat['0'] = $this->Language->phrase('main_category');
        $cats = Form_helper::queryToDropdown('blog_categories', 'blog_category_id', 'title', $cat, 'WHERE parent = "0"');
        if ($model->save())
            Uri_helper::redirect("management/blog_categories");
        else
            return $this->render('blog_categories/manage', [
                        'item' => $id ? $model->get() : null,
                        'categories' => $cats
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\blog\models\Blog_categories();
        $model->blog_category_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/blog_categories");
    }

}
