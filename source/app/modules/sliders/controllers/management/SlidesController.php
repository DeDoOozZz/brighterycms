<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Slides 
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module sliders
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/sliders
 * @controller SlidesController
 *
 * */
class SlidesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('sliders');
    }

    public function indexAction($id = false, $offset = 0) {
        $this->permission('index');
        $model = new \modules\sliders\models\Slides();
        $model->slider_id = $id;
        $model->_select = "slide_id, title, image, slider_id";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/sliders/slides/' . $id),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset,
        ];
        return $this->render('sliders/slides', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config),
                    'id' => $id
        ]);
    }

    public function addAction($id) {
        return $this->manageAction(false, $id);
    }

    public function manageAction($id = false, $slider_id = false) {
        $this->permission('manage');
        if ($id) {
            $model = new \modules\sliders\models\Slides('edit');
            $model->slide_id = $id;
        } else {
            $model = new \modules\sliders\models\Slides('add');
            $model->slider_id = $slider_id;
        }
        $model->set($this->Input->post());

        $model->language_id = $this->language->getDefaultLanguage();

        if (!$id)
            $model->created = date("Y-m-d H:i:s");
        if ($model->save()) {
            Uri_helper::redirect("management/sliders");
        }
        return $this->render('sliders/manage_slide', [
                    'item' => $id ? $model->get() : null
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\sliders\models\Slides();
        $model->slide_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/sliders");
    }

}
