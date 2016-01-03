<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Blog Posts
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module blog
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/blog
 * @controller Blog_postsController
 *
 * */
class Blog_postsController extends Brightery_Controller {

    public function __construct() {
        parent::__construct();
        $this->language->load("blog_posts");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $model = new \modules\blog\models\Blog_posts();
        $model->_select = 'blog_posts.*, users.fullname, blog_categories.title AS category';
        $model->_joins = [
            'users' => ['`users`.`user_id`=`blog_posts`.`user_id`', 'inner'],
            'blog_categories' => ['`blog_categories`.`blog_category_id`=`blog_posts`.`blog_category_id`', 'inner']
        ];
//        $model->language_id = $this->language->getDefaultLanguage();
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/blog_posts/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('blog_posts/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $userInfo = $this->permissions->getUserInformation();

        if ($id) {
            $model = new \modules\blog\models\Blog_posts('edit');
            $model->blog_post_id = $id;
        } else {
            $model = new \modules\blog\models\Blog_posts('add');
            $model->created = date("Y-m-d H:i:s");
            $model->user_id = $userInfo->user_id;

            $model->language_id = $this->language->getDefaultLanguage();
        }
        $model->set('title', $this->Input->post('title'));
        $model->set('seo', $this->Input->post('seo'));
        $model->set('short_content', $this->Input->post('short_content'));
        $model->set('content', $this->Input->post('content'));
        $model->set('blog_category_id', $this->Input->post('blog_category_id'));
        $model->set('language_id', $this->Input->post('language_id'));

        $blog_category = Form_helper::queryToDropdown('blog_categories', 'blog_category_id', 'title');

        if ($model->save())
            Uri_helper::redirect("management/blog_posts");
        else
            return $this->render('blog_posts/manage', [
                        'item' => $id ? $model->get() : null,
                        'blog_category' => $blog_category,
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\blog\models\Blog_posts();
        $model->blog_post_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/blog_posts");
    }

}
