<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pm_project_details controller
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@info.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pm
 * @controller Pm_project_details
 *
 * */
class Pm_project_detailsController extends Brightery_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->language->load('pm_project_details');


    }

    function indexAction($id = false) {

        if (!$id)
         return   Brightery::error404();

        $this->permission('index');
        $projects = new \modules\pm\models\Pm_projects();
        $projects->_select = "pm_project_id,title,about,deadline,"
                . " (SELECT users.fullname FROM users WHERE users.user_id "
                . "= pm_projects.pm_supervisor_id) AS supervisor";
        $projects->pm_project_id = $id;
        $issues = new \modules\pm\models\Pm_issues();
        $issues->_select = "pm_issue_id,title";
        $issues->pm_project_id = $id;

        $team_result = $this->database->query(
                "SELECT title,pm_teams.`pm_team_id` AS id
                FROM pm_teams_projects JOIN pm_teams
                ON pm_teams_projects.`pm_team_id` = pm_teams.`pm_team_id`
                where pm_teams_projects.pm_project_id= $id "
            )->result();
        
        $member_result = [];
        
        foreach ($team_result as $value) {
            
            $member_result [] =
                    ['team'=>$value->title,
                        'member'=> $this->database->query(
                            "SELECT  fullname , title
                             FROM pm_team_users JOIN users
                             ON pm_team_users.`user_id` = users.`user_id`                                                        
                             JOIN pm_roles
                             ON pm_team_users.`pm_role_id` = pm_roles.`pm_role_id`
                             WHERE pm_team_users.pm_team_id=$value->id
                         ")->result()];
        }
       
   
        return $this->render('pm_project_details/index', [
                    'item' => $projects->get(),
                    'issues' => $issues->get(),
                    'team_results' => $team_result,
                    'member_results' => $member_result
        ]);
    }

}
