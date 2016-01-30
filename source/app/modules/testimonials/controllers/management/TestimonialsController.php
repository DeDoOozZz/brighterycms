<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Testimonials 
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module testimonials
 * @category general
 * @module_version  1.0

 * @link http://store.brightery.com/module/general/testimonials
 * @controller TestimonialsController
 * */
class TestimonialsController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('testimonials');
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $model = new \modules\testimonials\models\Testimonials();
        $model->_select = "testimonial_id,client_name,client_position,message,image";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/testimonials/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('testimonials/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $visibility = Form_helper::queryToDropdown('visibility_status', 'visibility_status_id', 'name');
        if ($id)
            $model = new \modules\testimonials\models\Testimonials('edit');
        else
            $model = new \modules\testimonials\models\Testimonials('add');

        $model->attributes = $this->Input->post();
        if ($id)
            $model->testimonial_id = $id;

        if ($model->save()) {
            Uri_helper::redirect("management/testimonials");
        }
        return $this->render('testimonials/manage', [
                    'item' => $id ? $model->get() : null,
                    'visibility' => $visibility
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\testimonials\models\Testimonials();
        $model->testimonial_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/testimonials");
    }

}
