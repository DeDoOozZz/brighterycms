<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Projects controller
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@info.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pm
 * @controller Projects
 *
 * */
class Pm_projectsController extends Brightery_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->language->load('pm_projects');

    }

    public function indexAction($offset=0) {
        $this->permission('index');
        $this->load->library('pagination');
        $model = new \modules\pm\models\Pm_projects();
        $model->_select = "pm_project_id, title, about,tags,
        (SELECT users.fullname FROM users WHERE users.user_id = pm_projects.pm_supervisor_id) AS supervisor, deadline";
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/pm_projects/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];

        return $this->render('pm_projects/index', [
            'items' => $model->get(),           
            'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false) {

        $this->permission('manage');
        $model = new \modules\pm\models\Pm_projects();
        $user = new \modules\users\models\Users();
        $team_project = new \modules\pm\models\Pm_teams_projects(false);

        $model->attributes = $this->input->post();
        if ($id)
            $model->pm_project_id = $id;
        if (!$id)
            $model->created = date("Y-m-d H:i:s");

        $users = [];
        foreach ($user->get() as $item) {
            $users [$item->user_id] = $item->fullname;
        }

        if ($id) {
            $model->pm_project_id = $id;

        }
        $team_project->_select = "pm_team_project_id, pm_team_id, pm_project_id";
        $teams = Form_helper::queryToDropdown('pm_teams', 'pm_team_id', 'title');

        if ($pid = $model->save())
        {
             foreach ($this->input->post('pm_teams') as $teamproject)
             {
                 $team_project->pm_team_id = $teamproject ;
                 $team_project->pm_project_id = $pid;
                 $team_project->save();

             }

                Uri_helper::redirect("management/pm_projects");

        }

        else
            return $this->render('pm_projects/manage', [
                    'item' => $id ? $model->get() : null,
                    'team' => $teams,
                    'user' => $users,
                    'team_project' => $id ? $team_project->get() : null

        ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
           return Brightery::error404("The page you requested is not found.");
        $model = new \modules\pm\models\Pm_projects();
        $model->pm_project_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/pm_projects");
    }
}
