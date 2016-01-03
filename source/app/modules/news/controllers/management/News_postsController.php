<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * News Posts
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module news
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/news
 * @controller News_postsController
 **/
class News_postsController extends Crud
{
    protected $layout = 'default';
    protected $_model = 'News_posts';

    public function manageAction($id = false)
    {
        $this->_data = [
            'news_categories' => Form_helper::queryToDropdown('news_categories', 'news_category_id', 'title')
        ];

        return parent::manageAction($id);
    }

}
