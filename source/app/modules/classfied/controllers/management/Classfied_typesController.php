<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Types Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_typesController
 *
 * */
class Classfied_typesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_types");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');

        $classfied = new \modules\classfied\models\Classfied_types();
        $classfied->_select = "classfied_type_id, name, var_name, color";
        $this->load->library('pagination');
        $classfied->_limit = $this->config->get('limit');
        $classfied->_offset = $offset;
        $config = [

            'url' => Uri_helper::url('management/classfied_types/index'),
            'total' => $classfied->get(true),
            'limit' => $classfied->_limit,
            'offset' => $classfied->_offset
        ];
        return $this->render('classfied_types/index', [
                    'items' => $classfied->get(),
                    'pagination' => $this->Pagination->generate($config),
                    'category_model' => $classfied
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $classfied = new \modules\classfied\models\Classfied_types();
        $classfied->set('name', $this->input->post('name'));
        $classfied->set('var_name', $this->input->post('var_name'));
        $classfied->set('color', $this->input->post('color'));
        if ($id)
            $classfied->classfied_type_id = $id;
        $classfied->language_id = $this->language->getDefaultLanguage();

        if ($classfied->save()) {
            Uri_helper::redirect("management/classfied_types");
        } else
            return $this->render('classfied_types/manage', [
                        'item' => $id ? $classfied->get() : null,
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $classfied = new \modules\classfied\models\Classfied_types();
        $classfied->classfied_type_id = $id;
        if ($classfied->delete())
            Uri_helper::redirect("management/classfied_types");
    }

}
