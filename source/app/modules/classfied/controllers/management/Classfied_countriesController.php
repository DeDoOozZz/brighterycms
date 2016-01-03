<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied_countries Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_countriesController
 * */
class Classfied_countriesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_countries");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $this->load->library('pagination');
        $classfied = new \modules\classfied\models\Classfied_countries();

        $classfied->_select = "classfied_country_id, name, image";
        $classfied->_limit = $this->config->get('limit');
        $classfied->_offset = $offset;

        return $this->render('classfied_countries/index', array(
                    'items' => $classfied->get(),
                    'pagination' => $this->Pagination->generate(array(
                        'url' => Uri_helper::url('management/classfied_countries/index'),
                        'total' => $classfied->get(TURE),
                        'limit' => $classfied->_limit,
                        'offset' => $classfied->_offset
                            )
                    )
        ));
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        if ($id) {
            $classfied = new \modules\classfied\models\Classfied_countries('edit');
            $classfied->classfied_country_id = $id;
        } else
            $classfied = new \modules\classfied\models\Classfied_countries('add');

        $classfied->set('name', $this->input->post('name'));

        if ($classfied->save())
            Uri_helper::redirect("management/classfied_countries");
        else
            return $this->render('classfied_countries/manage', array(
                        'item' => $id ? $classfied->get() : null
            ));
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $classfied = new \modules\classfied\models\Classfied_countries();
        $classfied->classfied_country_id = $id;
        if ($classfied->delete())
            Uri_helper::redirect("management/classfied_countries");
    }

}
