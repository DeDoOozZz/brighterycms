<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied_areas Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_areasController
 * */
class Classfied_areasController extends Brightery_Controller {

    //protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_areas");
    }

    public function indexAction($id = false, $offset = 0) {
        $this->permission('index');
        $model = new \modules\classfied\models\Classfied_areas();
        $model->classfied_city_id = $id;
        $model->_select = "classfied_area_id, name, classfied_city_id";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/classfied_areas/index/' . $id),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset,
        ];
        return $this->render('classfied_countries/areas_index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config),
                    'id' => $id
        ]);
    }

    public function addAction($classfied_city_id) {
        return $this->manageAction(false, $classfied_city_id);
    }

    public function manageAction($id = false, $classfied_city_id = false) {
        $this->permission('manage');
        $model = new \modules\classfied\models\Classfied_areas();
        if ($id) {
            $model->classfied_area_id = $id;
        } else {
            $model->classfied_city_id = $classfied_city_id;
        }

        $model->set($this->Input->post());

        $model->language_id = $this->language->getDefaultLanguage();

        if ($area_id = $model->save()) {
            $model->classfied_area_id = $area_id;
            $area = $model->get();
            Uri_helper::redirect("management/classfied_areas/index/$area->classfied_city_id");
        }
        return $this->render('classfied_countries/areas_manage', [
                    'item' => $id ? $area = $model->get() : null,
                    'city_id' => $id ? $area->classfied_city_id : $classfied_city_id
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\classfied\models\Classfied_areas();
        $model->classfied_area_id = $id;
        $area = $model->get();
        $model->classfied_city_id = $area->classfied_city_id;
        if ($model->delete())
            Uri_helper::redirect("management/classfied_areas/index/$area->classfied_city_id");
    }

}
