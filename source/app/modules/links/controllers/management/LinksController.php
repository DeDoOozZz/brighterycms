<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Links
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module links
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/links
 * @controller LinksController
 *
 * */
class LinksController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("links");
    }

    public function indexAction($id, $offset = 0) {
        $this->permission('index');
        $model = new \modules\links\models\Links();
        $model->_order_by['sort']='ASC'; 
//        $this->load->library('pagination');
//        $model->_limit = $this->config->get('limit');
//        $model->_offset = $offset;
//        $config = [
//            'url' => Uri_helper::url('management/Links/index'),
//            'total' => $model->get(true),
//            'limit' => $model->_limit,
//            'offset' => $model->_offset
//        ];
        return $this->render('links/index', [
                    'items' => $model->get(),
                    'id' => $id,
//                    'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function addAction($id = false) {
        return $this->manageAction(false, $id);
    }

    public function manageAction($id = false, $link_type = false) {
        $this->permission('manage');
        $model = new \modules\links\models\Links();
        $model->language_id = $this->language->getDefaultLanguage();
        if ($_POST)
            $model->attributes = $this->Input->input['post'];
        if ($link_type)
            $model->link_type_id = $link_type;
        if ($id)
            $model->link_id = $id;
        $model->language_id = $this->language->getDefaultLanguage();
        if (!$id)
            $model->created = date("Y-m-d H:i:s");

        if ($sid = $model->save()) {
            $model->link_id = $sid;
            $item = $model->get();
            Uri_helper::redirect("management/links/index/" . $item->link_type_id);
        } else
            return $this->render('links/manage', [
                        'item' => $id ? $model->get() : null,
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\links\models\Links();
        $model->link_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/Links");
    }

    public function resortAction() {
        $this->layout = 'ajax';
        foreach ($this->input->post('sort') as $links) {
            $this->database->where('link_id', $links['link_id'])->update('links', array(
                'sort' => $links['sort']
            ));
        }
    }

}
