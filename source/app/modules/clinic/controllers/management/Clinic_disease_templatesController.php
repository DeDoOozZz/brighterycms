<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clinic_disease_templates Controller
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0

 * @interface management
 * @module clinic
 * @category general
 * @module_version  1.0

 * @link http://store.brightery.com/module/general/Clinic_disease_templates
 * @controller Clinic_disease_templates
 * */
class Clinic_disease_templatesController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->language->load("clinic_disease_templates");
        $model = new \modules\clinic\models\Clinic_disease_templates();
        $model->_select = "clinic_disease_template_id,title,content,language_id";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/clinic_disease_templates/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('clinic_disease_templates/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->auth = true;
        $this->permission('manage');
        $this->language->load("clinic_disease_templates");
        $model = new \modules\clinic\models\Clinic_disease_templates();
        $model->attributes = $this->Input->input['post'];
        if ($id)
            $model->clinic_disease_template_id = $id;
        $model->language_id = $this->language->getDefaultLanguage();

        if ($model->save())
            Uri_helper::redirect("management/clinic_disease_templates");
        else
            return $this->render('clinic_disease_templates/manage', [
                        'item' => $id ? $model->get() : null
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\clinic\models\Clinic_disease_templates();
        $model->clinic_disease_template_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/clinic_disease_templates");
    }

}
