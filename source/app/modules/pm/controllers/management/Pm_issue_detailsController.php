<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Issue Details
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@brightery.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pm
 * @controller Pm_issue_detailsController
 *
 **/
class Pm_issue_detailsController extends Brightery_Controller {

    public function __construct(){
        parent::__construct();
        $this->language->load("pm_issue_details");
    }

    public function indexAction($id = false) {
        if (!$id)
            return Brightery::error404();

        $this->permission('index');

        $issues = new \modules\pm\models\Pm_issues();
        $issues->_select = "pm_issue_id, title, description,pm_project_id,pm_priority_id , deadline ,estimated_time,
        (SELECT users.fullname FROM users WHERE users.user_id = pm_issues.pm_reviewer_id) AS reviewer,
        (SELECT pm_projects.title FROM pm_projects WHERE pm_projects.pm_project_id = pm_issues.pm_project_id) AS project,
        (SELECT pm_priorities.color FROM pm_priorities WHERE pm_priorities.pm_priority_id = pm_issues.pm_priority_id) AS priority,
        (SELECT pm_priorities.name FROM pm_priorities WHERE pm_priorities.pm_priority_id = pm_issues.pm_priority_id) AS priority_title,
        (SELECT pm_issues_types.title FROM pm_issues_types WHERE pm_issues_types.pm_issue_type_id = pm_issues.pm_issue_type_id) AS issue_type ";
        $issues->pm_issue_id = $id;

        $comments = new \modules\pm\models\Pm_comments();
        $comments->_select = "pm_comment_id,pm_issue_id,comment,time,parent,
        (SELECT users.fullname FROM users WHERE users.user_id = pm_comments.user_id) AS username,
        (SELECT users.image FROM users WHERE users.user_id = pm_comments.user_id) AS image";
        $comments->pm_issue_id = $id;
        $comments->parent = 0;
        $activities = new \modules\pm\models\Pm_history();
        $activities->pm_issue_id = $id;

        $attach = new \modules\pm\models\Pm_attachments();
        $attach->_select = "pm_attachment_id, file_name, type, pm_issue_id";
        $attach->pm_issue_id = $id;
        return $this->render('pm_issue_details/index', [
            'item' => $issues->get(),
           'comments' => $comments->get(),
            'attach' => $attach->get(),
            'comment_model' => $comments,
            'total' => $activities->takenTime($id),
            'assigned' =>$issues->assignedIssues($id)
        ]);
    }

    // Add Comments
    public function addcommentsAction($id = false) {
        $this->permission('addcomments');
        $this->layout = 'ajax';
        $userInfo = $this->permissions->getUserInformation();

        $comments = new \modules\pm\models\Pm_comments('add');
        $comments->user_id = $userInfo->user_id;
        $comments->time = date('Y-m-d H:i:s');
        $comments->pm_issue_id = $id;
        $comments->parent = $this->input->post('parent');
        $comments->comment = $this->input->post('comment');

        if ($id = $comments->save()) {
            $comments = new \modules\pm\models\Pm_comments();
            $comments->pm_comment_id = $id;
            $comments->_select = "pm_comment_id,pm_issue_id,comment,time,parent,
            (SELECT users.fullname FROM users WHERE users.user_id = pm_comments.user_id) AS username,
            (SELECT users.image FROM users WHERE users.user_id = pm_comments.user_id) AS image";

            return json_encode(['status' => 'success',
                'item' => $comments->get()]);
        }

        else
            return json_encode(['status' => 'faild']);

    }

    // Delete Comments
    public function deleteAction($id = false) {
        $this->permission('delete');
        $this->layout = 'ajax';

        if (!$id)
            return Brightery::error404("The page you requested is not found.");

        $model = new \modules\pm\models\pm_comments();
        $model->pm_comment_id = $id;
        if ($model->delete())
            return json_encode(['status' => 'success']);
        else
            return json_encode(['status' => 'faild']);

    }

    // Issue History Button
    public function historyAction ($id = false){

        $this->layout = 'ajax';
        $model = new \modules\pm\models\Pm_history();
        $model->_select="pm_history_id,actions,datetime,pm_issue_id,
        (SELECT users.fullname FROM users WHERE users.user_id = pm_history.from_user_id) AS from_user,
        (SELECT users.fullname FROM users WHERE users.user_id = pm_history.to_user_id) AS to_user
        ";

        $issues = new \modules\pm\models\Pm_issues();
        $issues->_select="pm_issue_id,title";
        $issues->pm_issue_id = $id;
         $model->_order_by['datetime'] = 'DESC';



        return $this -> render ('pm_issue_details/history', [
            'items' => $model -> get (),
            'issue' =>$issues ->get()


       ]);
    }

    // Reputations VS Infractions
    public function operationsAction ($id = false, $user_id){
        $this->layout = 'ajax';
        if($this->input->post('type') == 'infractions'){
            $infractions = new \modules\pm\models\Pm_infractions(false);
            $infractions->pm_issue_id =$id;
            $infractions->user_id = $user_id;
            $infractions->reson = $this->input->post('reason');
            $infractions->save();
        }


        if ($this->input->post('type') == 'reputations'){
            $reputation =  new \modules\pm\models\Pm_reputations(false);
            $reputation->pm_issue_id = $id;
            $reputation->user_id = $id;
            $reputation->reson = $this->input->post('reason');
            $reputation->save();
        }
        return $this -> render ('pm_issue_details/make_actions',[
            'issue_id'=>$id,
            'user_id' => $user_id
        ]);

    }


    // Issue Activities Buttons [start - pause - done]
    public function activitiesAction ($id = false){
        $this->layout = 'ajax';
        $userInfo = $this->permissions->getUserInformation();

        $activities = new \modules\pm\models\Pm_history('add');
        $activities->from_user_id = $userInfo->user_id;
        $activities->pm_issue_id = $id;
        $activities->datetime = date('Y-m-d H:i:s');
        $activities->actions = $this->input->post('actions');


        if ($aid = $activities->save()) {

            $activities = new \modules\pm\models\Pm_history();
            $activities -> pm_history_id = $aid;

            return json_encode(['status' => 'success',
            'item' => $activities->get(),
            'total' => $activities->takenTime($id)

            ]);
        }

        else

        return json_encode(['status' => 'faild']);


    }




}
