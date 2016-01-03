<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pm_issue_statues Controller
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@brightery.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pm
 * @controller Pm_issue_statues
 **/
class Pm_issue_statuesController extends Brightery_Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->language->load("pm_issue_statues");
    }

    public function indexAction($offset = 0) {

        $this->permission('index');
        $this->load->library('pagination');
        $pm_issue_statues = new \modules\pm\models\Pm_issue_statues();
        $pm_issue_statues->_select = "pm_issue_statues_id, title, color";
        $pm_issue_statues->_limit = $this->config->get('limit');
        $pm_issue_statues->_offset = $offset;

        return $this->render('pm_issue_statues/index', [
            'items' => $pm_issue_statues->get(),
            'pagination' => $this->Pagination->generate([
                'url' => Uri_helper::url('management/pm_issue_statues/index'),
                'total' => $pm_issue_statues->get(true),
                'limit' => $pm_issue_statues->_limit,
                'offset' => $pm_issue_statues->_offset
                ]
            )
        ]);
    }

    public function manageAction($id = false) {
        if($id) {
            $this->permission('edit');
        } else {
            $this->permission('add');
        }
        $this->language->load("pm_pm_issue_statues");
        $pm_issue_statues = new \modules\pm\models\Pm_issue_statues();
      if($_POST)
            $pm_issue_statues->attributes = [
                'title' => $this->input->post('title'),
                'color' => $this->input->post('color'),];
        if ($id)
            $pm_issue_statues->pm_issue_statues_id = $id;

        if ($pm_issue_statues->save())
            Uri_helper::redirect("management/pm_issue_statues");
        else
            return $this->render('pm_issue_statues/manage', [
                'item' => $id ? $pm_issue_statues->get() : null
          ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
          return  Brightery::error404();
        }
        $pm_issue_statues = new \modules\pm\models\Pm_issue_statues();
        $pm_issue_statues->pm_issue_statues_id = $id;
        if ($pm_issue_statues->delete())
            Uri_helper::redirect("management/pm_issue_statues");
    }
    
    
}
