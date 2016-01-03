<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Downloads
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module downloads
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/downloads
 * @controller DownloadsController
 *
 * */
class DownloadsController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('downloads');
    }

    public function indexAction($offset = 0) {
        $this->permission('index');
        $model = new \modules\downloads\models\Downloads();
        $model->_select = "download_id,language_id,url,image,created";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/downloads/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('downloads/index', [
                    'items' => $model->get(),
                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');

        if ($id)
            $model = new \modules\downloads\models\Downloads('edit');
        else
            $model = new \modules\downloads\models\Downloads('add');

        $model->attributes = $this->Input->post();

        if (!$id)
            $model->created = date("Y-m-d H:i:s");
        $model->language_id = $this->language->getDefaultLanguage();
        if ($id)
            $model->download_id = $id;

        if ($model->save()) {
            Uri_helper::redirect("management/downloads");
        }
        return $this->render('downloads/manage', [
                    'item' => $id ? $commerce->get() : null
        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\downloads\models\Downloads();
        $model->download_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/downloads");
    }

}
