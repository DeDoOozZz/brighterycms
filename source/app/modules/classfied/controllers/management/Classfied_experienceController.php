<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied experience Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_experienceController
 *
 * */
class Classfied_experienceController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_experience");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');

        $classfied = new \modules\classfied\models\Classfied_experience();
        $classfied->_select = "classfied_experience_id, name";
        $this->load->library('pagination');
        $classfied->_limit = $this->config->get('limit');
        $classfied->_offset = $offset;
        $config = [

            'url' => Uri_helper::url('management/classfied_experience/index'),
            'total' => $classfied->get(true),
            'limit' => $classfied->_limit,
            'offset' => $classfied->_offset
        ];
        return $this->render('classfied_experience/index', [
                    'items' => $classfied->get(),
                    'pagination' => $this->Pagination->generate($config),
                    'category_model' => $classfied
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $classfied = new \modules\classfied\models\Classfied_experience();
        $classfied->set('name', $this->input->post('name'));
        if ($id)
            $classfied->classfied_experience_id = $id;
        $classfied->language_id = $this->language->getDefaultLanguage();

        if ($classfied->save()) {
            Uri_helper::redirect("management/classfied_experience");
        } else
            return $this->render('classfied_experience/manage', [
                        'item' => $id ? $classfied->get() : null,
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $classfied = new \modules\classfied\models\Classfied_experience();
        $classfied->classfied_experience_id = $id;
        if ($classfied->delete())
            Uri_helper::redirect("management/classfied_experience");
    }

}
