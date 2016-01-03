<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Category Attributes
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_category_attributesController
 *
 * */
class Commerce_category_attributesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_category_attributes");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $commerce = new \modules\commerce\models\Commerce_category_attributes();
        $commerce->_joins = [
            'commerce_categories' => ['`commerce_categories`.`commerce_category_id`=`commerce_category_attributes`.`commerce_category_id`', 'INNER']
        ];
        
        $this->load->library('pagination');
        $commerce->_limit = $this->config->get('limit');
        $commerce->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/commerce_category_attributes/index'),
            'total' => $commerce->get(true),
            'limit' => $commerce->_limit,
            'offset' => $commerce->_offset
        ];
        
        return $this->render('commerce_category_attributes/index', [
                    'items' => $commerce->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $commerce = new \modules\commerce\models\Commerce_category_attributes();
        $commerce->attributes = $this->Input->input['post'];
        $cats = Form_helper::queryToDropdown('commerce_categories', 'commerce_category_id', 'title');

        if ($id)
            $commerce->commerce_category_attribute_id = $id;

        $commerce->language_id = $this->language->getDefaultLanguage();


        if ($commerce->save())
            Uri_helper::redirect("management/commerce_category_attributes");
        else
            return $this->render('commerce_category_attributes/manage', [
                        'item' => $id ? $commerce->get() : null,
                        'categories' => $cats
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce = new \modules\commerce\models\Commerce_category_attributes();
        $commerce->commerce_category_attribute_id = $id;
        if ($commerce->delete())
            Uri_helper::redirect("management/commerce_category_attributes");
    }

}
