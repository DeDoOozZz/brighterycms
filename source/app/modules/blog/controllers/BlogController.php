<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Blog 
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module blog
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/blog
 * @controller BlogController
 *
 * */
class BlogController extends Brightery_Controller {

    public function __construct() {
        parent::__construct();
        $this->language->load('blog_categories');
        $this->language->load('blog_posts');
        $this->language->load('blog_post_comments');
    }

    public function indexAction($seo = null) {
        $posts = new \modules\blog\models\Blog_posts();
        $categories = new \modules\blog\models\Blog_categories();
        if ($seo) {
            $categories->seo = $seo;
            $categories->_select = 'blog_category_id';
            $cat = $categories->get();
            if (!$cat)
                return Brightery::error404();
            $posts->blog_category_id = $cat->blog_category_id;
        }
        $categories->_select = 'seo, title';
        $categories->seo = FALSE;
        return $this->render('blog/index', [
                    'posts' => $posts->get(),
                    'categories' => $categories->get(),
        ]);
    }

    public function postAction($seo = null) {
        if (!$seo)
            return Brightery::error404();
        
        
        $userInfo = $this->permissions->getUserInformation();
        
        $model = new \modules\blog\models\Blog_posts();
        $categories = new \modules\blog\models\Blog_categories();
        
        $comments = new \modules\blog\models\Blog_post_comments($userInfo? 'registered': 'unregistered');
        
        $comments->_joins = [
            'users' => ['users.user_id = blog_post_comments.user_id', 'left']
        ];
        $model->seo = $seo;
        $item = $model->get();
        if (!$item)
            return Brightery::error404();

        if($userInfo)
        $comments->set([
            'name' => $userInfo->fullname,
            'email' => $userInfo->email,
            'user_id' => $userInfo->user_id,
            'comment' => $this->input->post('comment'),
            'datetime' => date('Y-m-d H:i:s'),
        ]);
        else
             $comments->set([
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'comment' => $this->input->post('comment'),
            'datetime' => date('Y-m-d H:i:s'),
        ]);
        $comments->blog_post_id = $item->blog_post_id;
        $comments->save();
        return $this->render('blog/post', [
                    'item' => $item,
                    'categories' => $categories->get(),
                    'comments' => $comments->get(),
                    'comments_no' => $comments->get(1),
                    'user' => $userInfo
        ]);
    }

}
