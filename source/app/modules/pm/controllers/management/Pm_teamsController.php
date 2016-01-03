<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pm_teams controller
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@info.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pm
 * @controller Pm_teams
 *
 **/

class Pm_teamsController extends Brightery_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->language->load("pm_teams");
    }

    public function indexAction ($offset = 0){
        $this->permission('index');
        $this->load->library('pagination');
        $model = new \modules\pm\models\Pm_teams();
        $model-> _select = "pm_team_id, title, description,
        (SELECT users.fullname FROM users WHERE users.user_id = pm_teams.pm_team_leader_id) AS team_leader";
         $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/pm_teams/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];
        return $this-> render('pm_teams/index',[
            'items'=> $model->get(),
            'pagination' => $this->Pagination->generate($config)
        ]);


    }

    public function manageAction($id = false){

        $this->permission('manage');
        $model = new \modules\pm\models\Pm_teams();
        $user = new \modules\users\models\Users();
        $team_users = new \modules\pm\models\Pm_team_users(false);
        $model->attributes = $this->Input->post();
        if($id)
            $model->pm_team_id = $id;
        if(!$id)
            $model->created = date("Y-m-d H:i:s");

        $users= [];
        foreach($user->get() as $item){
            $users[$item->user_id]=$item->fullname;
        }


        $team_users -> _select = "pm_team_users_id , pm_team_id, user_id,pm_role_id";
        $roles = Form_helper::queryToDropdown('pm_roles','pm_role_id', 'title');

        if( $tid = $model->save())
        {

            if ($id) {
                $team_users->pm_team_id = $id;
                $team_users->delete();
            }

         foreach ($this->input->post('add_user_id') as $key => $member_role){
             $team_users->user_id = $member_role;
             $team_users->pm_team_id = $tid ;
             $team_users->pm_role_id = $this->input->post('add_pm_role_id.'.$key);
             $team_users->save();
         }
            Uri_helper::redirect('management/pm_teams');
        }
        else
            return $this->render('pm_teams/manage',[
                'item'=> $id ? $model->get() : null,
                'team_users'=>$id ?  $team_users ->get() : null,
                'roles'=> $roles,
                'user'=>$users
            ] );
    }


    public function deleteAction ($id = false){
        $this->permission('delete');
        if (!$id)
          return  Brightery::error404("The page you requested is not found.");
        $model = new \modules\pm\models\Pm_teams();
        $members = new \modules\pm\models\Pm_team_users();
        $model->pm_team_id = $id;
        $members->pm_team_users_id= $id;
        if ($model->delete())
            $members->delete();
            Uri_helper::redirect("management/pm_teams");

    }

}