<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Sliders 
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module sliders
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/sliders
 * @controller SlidersController
 *
 * */
class SlidersController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('sliders');
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $model = new \modules\sliders\models\Sliders();
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/sliders/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('sliders/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $model = new \modules\sliders\models\Sliders();

        $model->attributes = $this->Input->post();
        if ($id)
            $model->slider_id = $id;
        $model->language_id = $this->language->getDefaultLanguage();
        if ($model->save()) {
            Uri_helper::redirect("management/sliders");
        }
        return $this->render('sliders/manage', [
                    'item' => $id ? $model->get() : null
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\sliders\models\Sliders();
        $model->slider_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/sliders");
    }


}
