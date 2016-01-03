<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Brands
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_brandsController
 * */
class Commerce_brandsController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("commerce_brands");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $commerce_brands = new \modules\commerce\models\Commerce_brands();
        $commerce_brands->_limit = $this->config->get('limit');
        $commerce_brands->_offset = $offset;

        return $this->render('commerce_brands/index', [
                    'items' => $commerce_brands->get(),
                    'pagination' => $this->Pagination->generate([
                        'url' => Uri_helper::url('management/commerce_brands/index'),
                        'total' => $commerce_brands->get(true),
                        'limit' => $commerce_brands->_limit,
                        'offset' => $commerce_brands->_offset
                            ]
                    )
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        if ($id) {
            $commerce_brands = new \modules\commerce\models\Commerce_brands('edit');
            $commerce_brands->commerce_brand_id = $id;
        } else
            $commerce_brands = new \modules\commerce\models\Commerce_brands('add');

        $commerce_brands->set($this->Input->post());
        
        $commerce_brands->language_id = $this->language->getDefaultLanguage();

        if ($commerce_brands->save()){
            Uri_helper::redirect("management/commerce_brands");
        }
        else
            return $this->render('commerce_brands/manage', [
                        'item' => $id ? $commerce_brands->get() : null
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce_brands = new \modules\commerce\models\Commerce_brands();
        $commerce_brands->commerce_brand_id = $id;
        if ($commerce_brands->delete())
            Uri_helper::redirect("management/commerce_brands");
    }

}
