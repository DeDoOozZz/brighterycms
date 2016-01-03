<?php defined('ROOT') OR exit('No direct script access allowed');
/**
 * Pm_sticky_issues Controller
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@brightery.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/Pm
 * @controller Pm_sticky_issues
 **/


class Pm_sticky_issuesController extends Brightery_Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->language->load("pm_issue_statues");
    }

    public function indexAction($offset = 0)
    {

        $this->permission('index');
        $this->load->library('pagination');
        $pm_issues = new \modules\pm\models\Pm_issues();
        $pm_issues->_select = "pm_issue_id, title, pm_issue_statues_id";
        $pm_issue_statues = new \modules\pm\models\Pm_issue_statues();
        $pm_issue_statues->_select = "pm_issue_statues_id, title, color";
        $pm_issue_statues->_limit = $this->config->get('limit');
        $pm_issue_statues->_offset = $offset;

        return $this->render('pm_sticky_issues/index', [
            'items' => $pm_issue_statues->get(),
            'issues' => $pm_issues->get(),
            'issue_model' => $pm_issues,
            'pagination' => $this->Pagination->generate([
                    'url' => Uri_helper::url('management/pm_sticky_issues/index'),
                    'total' => $pm_issue_statues->get(true),
                    'limit' => $pm_issue_statues->_limit,
                    'offset' => $pm_issue_statues->_offset
                ]
            )
        ]);
    }
}