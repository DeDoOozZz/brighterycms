<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pages Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module pages
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pages
 * @controller PagesController
 *
 **/
class PagesController extends Brightery_Controller
{
    protected $layout = 'classfied';

    public function indexAction($page = null)
    {
        if (!$page)
            Brightery::error404();

        $model = new \modules\pages\models\Pages();
        $model->language_id = $this->language->getDefaultLanguage();
        $model->seo = $page;
        $res = $model->get();
        if( ! $res)
            Brightery::error404();

        return $this->render('pages/index', [
            'item' => $res
        ]);
    }
}