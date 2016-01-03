<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied cities Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_citiesController
 *
 * */
class Classfied_citiesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_cities");
    }

    public function indexAction($id = false, $offset = 0) {
        $this->permission('index');
        $model = new \modules\classfied\models\Classfied_cities();
        $model->classfied_country_id = $id;
        $model->_select = "classfied_city_id, name, classfied_country_id";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/classfied_countries/cities_index/' . $id),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset,
        ];
        return $this->render('classfied_countries/cities_index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config),
                    'id' => $id
        ]);
    }

    public function addAction($classfied_country_id) {
        return $this->manageAction(false, $classfied_country_id);
    }

    public function manageAction($id = false, $classfied_country_id = false) {
        $this->permission('manage');
        $model = new \modules\classfied\models\Classfied_cities();
        if ($id) {
            $model->classfied_city_id = $id;
        } else {
            $model->classfied_country_id = $classfied_country_id;
        }
        
        $model->set($this->Input->post());

        $model->language_id = $this->language->getDefaultLanguage();

         if ($city_id = $model->save()) {
            $model->classfied_city_id = $city_id;
            $area = $model->get();
            Uri_helper::redirect("management/classfied_areas/index/$area->classfied_country_id");
        }
        return $this->render('classfied_countries/cities_manage', [
            'item' => $id ? $city = $model->get() : null,
            'country_id' => $id ? $city->classfied_country_id : $classfied_country_id
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\classfied\models\Classfied_cities();
        $model->classfied_city_id = $id;
        $city = $model->get();
        $model->classfied_country_id = $city->classfied_country_id;
        if ($model->delete())
            Uri_helper::redirect("management/classfied_cities/index/$city->classfied_country_id");
    }

}
