<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Blog 
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module portfolio
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/blog
 * @controller PortfolioController
 *
 * */
class PortfolioController extends Brightery_Controller {

    public function __construct() {
        parent::__construct();
        $this->language->load('portfolio_categories');
        $this->language->load('portfolio');
    }

    public function indexAction($seo = null) {
        $portfolio = new \modules\portfolio\models\Portfolio();
        $categories = new \modules\portfolio\models\Portfolio_categories();
        if ($seo) {
            $categories->seo = $seo;
            $categories->_select = 'blog_category_id, title';
            $cat = $categories->get();
            if (!$cat)
                return Brightery::error404();
            $portfolio->portfolio_category_id = $cat->portfolio_category_id;
        }
        $categories->_select = 'seo, title, portfolio_category_id';
        $categories->seo = FALSE;
        return $this->render('index', [
                    'portfolio' => $portfolio->get(),
                    'categories' => $categories->get(),
        ]);
     
    }

    public function portfolio_itemAction($seo = null) {
        if (!$seo)
            return Brightery::error404();
        $portfolio_item = new \modules\portfolio\models\Portfolio();
        $portfolio_item->seo = $seo;
        print_r($portfolio_item->get());
        return $this->render('portfolio_item', [
                'item' => $portfolio_item->get(),
        ]);
    }

}
