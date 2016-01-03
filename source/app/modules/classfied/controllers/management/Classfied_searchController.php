<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Categories Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_categoriesController
 *
 * */
class Classfied_categoriesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_categories");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');

        $classfied = new \modules\classfied\models\Classfied_categories();
        $classfied->_select = "classfied_category_id, name, var_name, title, description, keywords, category_order, icon";
        $this->load->library('pagination');
        $classfied->_limit = $this->config->get('limit');
        $classfied->_offset = $offset;
        $config = [

            'url' => Uri_helper::url('management/classfied_categories/index'),
            'total' => $classfied->get(true),
            'limit' => $classfied->_limit,
            'offset' => $classfied->_offset
        ];
        return $this->render('classfied_categories/index', [
                    'items' => $classfied->get(),
                    'pagination' => $this->Pagination->generate($config),
                    'category_model' => $classfied
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        if ($id) {
            $classfied = new \modules\classfied\models\Classfied_categories('edit');
            $classfied->classfied_category_id = $id;
        } else
            $classfied = new \modules\classfied\models\Classfied_categories('add');

        $classfied->set('name', $this->input->post('name'));
        $classfied->set('var_name', $this->input->post('var_name'));
        $classfied->set('title', $this->input->post('title'));
        $classfied->set('description', $this->input->post('description'));
        $classfied->set('keywords', $this->input->post('keywords'));
        $classfied->set('category_order', $this->input->post('category_order'));

        $classfied->language_id = $this->language->getDefaultLanguage();

        if ($classfied->save()) {

            Uri_helper::redirect("management/classfied_categories");
        } else
            return $this->render('classfied_categories/manage', [
                        'item' => $id ? $classfied->get() : null,
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $classfied = new \modules\classfied\models\Classfied_categories();
        $classfied->classfied_category_id = $id;
        if ($classfied->delete())
            Uri_helper::redirect("management/classfied_categories");
    }

}
