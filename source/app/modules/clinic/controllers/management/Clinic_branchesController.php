<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Clinic_barnches Controller
 * @package Brightery CMS
 * @author <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module clinic
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/clinic
 * @controller Clinic_branches
 * */
class Clinic_branchesController extends Brightery_Controller
{

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction($offset = 0)
    {

        $this->permission('index');
        $this->language->load("clinic_branches");
        $model = new \modules\clinic\models\Clinic_branches();
        if ($this->input->get('clinic_branch_search'))
            $model->clinic_branch = $this->input->get('clinic_branch_search');
        if ( $this->input->get('phone_search'))
            $model->phone = $this->input->get('phone_search');
        $model->_select = "clinic_branch_id, clinic_branch, phone, address, longitude, latitude, description";
        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/clinic_branches/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this->render('clinic_branches/index', [
            'items' => $model->get(),
            'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false)
    {
        $this->auth = true;
        $this->permission('manage');
        $this->language->load("clinic_branches");
        $model = new \modules\clinic\models\Clinic_branches();
        $model->attributes = $this->Input->input['post'];
        if ($id)
            $model->clinic_branch_id = $id;
        $model->language_id = $this->language->getDefaultLanguage();

        if ($model->save())
            Uri_helper::redirect("management/clinic_branches");
        else
            return $this->render('clinic_branches/manage', [
                'item' => $id ? $model->get() : null
            ]);
    }

    public function deleteAction($id = false)
    {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\clinic\models\Clinic_branches();
        $model->clinic_branch_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/clinic_branches");
    }

}
