<?php defined('ROOT') OR exit('No direct script access allowed');
/**
 * Clinic_specifications Controller
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module clinic
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/clinic
 * @controller Clinic_specifications
 **/
class Clinic_specificationsController extends Brightery_Controller
{

    public function indexAction($offset = 0)
    {
        $this->permission('index');
        $this->language->load("clinic_specifications");
        $model = $model = new \modules\clinic\models\Clinic_specifications();
        if ($this->input->get('specification_search'))
            $model->specification = $this->input->get('specification_search');


        $this->load->library('pagination');
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/clinic_specifications/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];

        return $this->render('clinic_specifications/index', [
            'items' => $model->get(),
//            'specification' => $specification,
            'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = null)
    {
        $this->permission('manage');
        $this->language->load("clinic_specifications");
        $model = new \modules\clinic\models\Clinic_specifications();
        $branches = new \modules\clinic\models\Clinic_branches();
        $clinic_specification_branches = new \modules\clinic\models\Clinic_specification_branches(false);
        $clinic_specification_branches->_select = 'clinic_branch_id';
        if ($id)
            $model->clinic_specification_id = $id;
        $model->language_id = $this->language->getDefaultLanguage();
        $model->set('specification', $this->input->post('specification'));
        $model->set('description', $this->input->post('description'));

        if ($sid = $model->save()) {
            if($id) {
                $clinic_specification_branches->clinic_specification_id = $id;
                $clinic_specification_branches->delete();
            }
            foreach($this->input->post('branches') as $branch)
            {
                $clinic_specification_branches->clinic_specification_id = $sid;
                $clinic_specification_branches->clinic_branch_id = $branch;
                $clinic_specification_branches->save();
            }
            Uri_helper::redirect("management/clinic_specifications");
        }

        return $this->render('clinic_specifications/manage', [
            'item' => $id ? $model->get() : null,
            'branches' => $branches->get(),
            'selected_branches' => Form_helper::objToDropdown($clinic_specification_branches->get(), 'clinic_branch_id', 'clinic_branch_id')
        ]);
    }

    public function deleteAction($id = false)
    {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $model = new \modules\clinic\models\Clinic_specifications();
        $model->clinic_specification_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/clinic_specifications");
    }

}
