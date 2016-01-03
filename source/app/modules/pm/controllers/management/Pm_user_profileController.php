<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pm_user_profile controller
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@info.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/Pm
 * @controller Pm_user_profile
 *
 * */

class Pm_user_profileController extends Brightery_Controller {




    public function __construct(){
        parent::__construct();
        $this->language->load("pm_user_profile");
    }


    public function indexAction($id = false){

        if (!$id)
          return  Brightery::error404();
        $this->permission('index');
        $users = new \modules\users\models\Users();
        $users->_select ="user_id,fullname,image,status,
          (SELECT  usergroups.name FROM usergroups WHERE usergroups.usergroup_id = users.usergroup_id) AS usergroup
       ";
        $users->user_id = $id;
        $teams = new \modules\pm\models\Pm_team_users();
        $teams->_select = "pm_team_users_id, user_id,
          (SELECT  pm_teams.title FROM pm_teams WHERE pm_teams.pm_team_id = Pm_team_users.pm_team_id) AS team,
          (SELECT  pm_roles.title FROM pm_roles WHERE pm_roles.pm_role_id = Pm_team_users.pm_role_id) AS role
       ";
        $teams->user_id = $id;

        $project_count = $this->database->query(
            "SELECT COUNT(*) AS projects
               FROM (
                   SELECT DISTINCT  `pm_projects`.`pm_project_id`
            FROM   `brighterycms`.`pm_projects`
                RIGHT JOIN  `brighterycms`.`pm_teams_projects`ON (`pm_teams_projects`.`pm_project_id` = `pm_projects`.`pm_project_id`)
                INNER JOIN `brighterycms`.`pm_teams`  ON (`pm_teams_projects`.`pm_team_id` = `pm_teams`.`pm_team_id`)
                INNER JOIN `brighterycms`.`pm_team_users` ON (`pm_team_users`.`pm_team_id` = `pm_teams`.`pm_team_id`)
            WHERE (`pm_team_users`.`user_id` = $id)
            ) t;"

        )->row();

        $issue_count = $this->database->query(
            "SELECT COUNT(*) AS issues
              FROM (
                SELECT pm_history.pm_issue_id
                 FROM
                `brighterycms`.`pm_history`
                INNER JOIN `brighterycms`.`pm_issues`
                    ON (`pm_history`.`pm_issue_id` = `pm_issues`.`pm_issue_id`)
                 WHERE (`pm_history`.`actions` ='assign' AND `pm_history`.`to_user_id` = $id)
              ) s;"
        )->row();

        $assign = $this->database->query(
            "SELECT pm_issues.title AS issue_title ,pm_issues.pm_issue_id, actions = 'assign' AS assign ,
            DATETIME AS assigned_date , NAME AS priority , pm_priorities.color AS p_color , pm_issue_statues.`title` AS statues , pm_issue_statues.`color` AS s_color
            FROM pm_issues JOIN  pm_history
            ON pm_issues.`pm_issue_id`= pm_history.`pm_issue_id`
            JOIN users
            ON users.user_id = pm_history.to_user_id
            JOIN pm_priorities
            ON pm_priorities.`pm_priority_id` = pm_issues.`pm_priority_id`
            JOIN pm_issue_statues
            ON pm_issue_statues.`pm_issue_statues_id` = pm_issues.`pm_issue_statues_id`
            WHERE pm_history.to_user_id = $id"
        )->result();

        $actions = $this->database->query(
            "SELECT *, 'Infraction' AS actions , (SELECT pm_issues.`title` FROM pm_issues WHERE pm_issues.`pm_issue_id` = pm_infractions.`pm_issue_id`) AS issue_title FROM `pm_infractions`
            WHERE pm_infractions.`user_id` = $id
            UNION
            SELECT *, 'Reputation' AS actions , (SELECT pm_issues.`title` FROM pm_issues WHERE pm_issues.`pm_issue_id` = pm_reputations.`pm_issue_id`) AS issue_title FROM `pm_reputations`
            WHERE pm_reputations.`user_id` = $id"
        )->result();

        return $this->render('pm_user_profile/index',[
            'item' => $users->get(),
            'teams' => $teams->get(),
            'assign' => $assign,
            'actions' => $actions,
            'project_count' => $project_count,
            'issue_count' => $issue_count,

        ]);
    }
}