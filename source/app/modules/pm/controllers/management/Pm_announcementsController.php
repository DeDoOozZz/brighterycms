<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Announces controller
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@brightery.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pm
 * @controller Announces
 *
 **/

class Pm_announcementsController  extends Brightery_Controller {

    public function __construct()
    {
        parent::__construct();
         $this -> language->load ('pm_announcements');
    }



    public function indexAction($offset = 0) {
        $this -> permission ('index');
        $this->load->library('pagination');
        $model = new \modules\pm\models\Pm_announcements();
        $model -> select = "pm_announce_id, title, content, time ";
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/pm_announcements/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this -> render ('pm_announcements/index', [
            'items' => $model -> get (),
             'pagination' => $this->Pagination->generate($config)
        ]);

    }

    public function  manageAction ($id = false){
        $this -> permission ('manage');

            $model = new \modules\pm\models\Pm_announcements();
            $model->attributes = $this->Input->post();
        if ($id)
            $model->pm_announce_id = $id;
        if (!$id)
            $model->created = date("Y-m-d H:i:s");
        if ($model->save())
            Uri_helper::redirect("management/pm_announcements");
        else
            return $this->render('pm_announcements/manage', [
                'item' => $id ? $model->get() : null
            ]);


    }

    public function previewAction ($id = false){

        $this->layout = 'ajax';
        $this -> language->load ('pm_announcements');
        $model = new \modules\pm\models\Pm_announcements();
        $model->pm_announce_id = $id;
        return $this -> render ('pm_announcements/preview', [
            'item' => $model -> get ()
        ]);
    }


    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
           return Brightery::error404("The page you requested is not found.");
        $model = new \modules\pm\models\Pm_announcements();
        $model->pm_announce_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/pm_announcements");
    }

}

