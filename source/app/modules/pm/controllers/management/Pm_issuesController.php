<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Issues
 *
 * @package Brightery CMS
 * @author  Esraa Abd El-Rahim <esraa.ahmad@brightery.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/pm
 * @controller Pm_issuesController
 * */
class Pm_issuesController extends Brightery_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->language->load("pm_issues");
    }

    public function indexAction($offset = 0)
    {
        $this->permission('index');
        $this->load->library('pagination');

        $model = new \modules\pm\models\Pm_issues();
        $model->_select = "pm_issue_id,title,description,pm_reviewer_id,pm_issue_statues_id
        pm_project_id,created_time,estimated_time,parent,pm_priority_id,deadline,pm_issue_type_id";
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/pm_issues/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];

        $model_priorities = new \modules\pm\models\Pm_priorities();
        $model_priorities->_select = "pm_priority_id ,name ,color";
        $priorities = $model_priorities->get();
        return $this->render('pm_issues/index', [
            'items' => $model->get(),
            'priorities' => $priorities,
            'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false)
    {
        $userInfo = $this->permissions->getUserInformation();
        $this->permission('manage');

        $users = Form_helper::queryToDropdown('users', 'user_id', 'fullname');
        $priorities = Form_helper::queryToDropdown('pm_priorities', 'pm_priority_id', 'name');
        $projects = Form_helper::queryToDropdown('pm_projects', 'pm_project_id', 'title');
        $types = Form_helper::queryToDropdown('pm_issues_types', 'pm_issue_type_id', 'title');

        $attach = new \modules\pm\models\Pm_attachments(false);
        $assign = new \modules\pm\models\Pm_history(false);

        if ($id) {
            $model = new \modules\pm\models\Pm_issues('edit');
            $model->pm_issue_id = $id;
            $attach->pm_issue_id = $id;
            $assign->pm_issue_id = $id;
        } else {
            $model = new \modules\pm\models\Pm_issues('add');
            $model->set('created_time', date('Y-m-d H:i:s'));
        }

        $model->set([
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'pm_reviewer_id' => $this->input->post('pm_reviewer_id'),
            'pm_project_id' => $this->input->post('pm_project_id'),
            'pm_priority_id' => $this->input->post('pm_priority_id'),
            'estimated_time' => $this->input->post('estimated_time'),
            'deadline' => $this->input->post('deadline'),
            'pm_issue_type_id' => $this->input->post('pm_issue_type_id'),
            'pm_issue_statues_id' => $this->input->post('pm_issue_statues_id')
        ]);

        if ($issue_id = $model->save()) {
            if (!$id)
                if ($this->input->post('to_user_id')) {
                    $assign->set([
                        'from_user_id' => $userInfo->user_id,
                        'to_user_id' => $this->input->post('to_user_id'),
                        'pm_issue_id' => $issue_id,
                        'actions' => 'assign',
                        'datetime' => date('Y-m-d H:i:s')
                    ]);
                    $assign->save();
                }

            $attach->pm_issue_id = $issue_id;
            $attach->delete();
            foreach ($this->input->post('uploaded_files') as $file) {
                $attach->pm_issue_id = $issue_id;
                $attach->file_name = $file;
                $attach->attachment_type = 'issue';
                $attach->uploaded_time = date('Y-m-d H:i:s');
                $attach->save();
            }

            Uri_helper::redirect("management/pm_issues");
        } else
            return $this->render('pm_issues/manage', [

                    'item' => $id ?  $model->get() : null,
                    'attach' => $id ? $attach->get() : null,
                    'users' => $users,
                    'pm_projects' => $projects,
                    'priority' => $priorities,
                    'assign' => $assign,
                    'types' => $types
            ]);
    }

    public function deleteAction($id = false)
    {
        $this->permission('delete');
        if (!$id) {
            Brightery::error404("The page you requested is not found.");
        }
        $model = new \modules\pm\models\Pm_issues();
        $attach = new \modules\pm\models\Pm_attachments();
        $model->pm_issue_id = $id;
        $attach->pm_issue_id = $id;
        $attach->pm_attachment_id;
        if ($model->delete())
            Uri_helper::redirect("management/pm_issues");
        if ($attach->delete())
            return json_encode(['sucess' => 1]);


    }

    public function manage_filesAction($id = false)
    {
        $this->layout = 'ajax';
        if ($id) {
            $model = new \modules\pm\models\Pm_attachments();

        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!$id)
                return false;
            $model->pm_issue_id = $id;
            foreach ($model->get() as $file) {
                $filename = $file->file_name;
                $file_id = $file->pm_attachment_id;
                $files[] = [
                    'name' => $filename,
                    'size' => filesize('./cdn/' . $this->_module . '/' . $filename),
                    'url' => Uri_helper::cdn($this->_module . '/' . $filename),
                    'primary' => $file->primary,
                    'thumbnailUrl' => Uri_helper::cdn($this->_module . '/' . $filename),
                    'deleteUrl' => Uri_helper::url('management/pm_issues/manage_files/' . $file_id) . '?file=' . $filename,
                    'deleteType' => 'DELETE'
                ];
            }
            return json_encode(['files' => $files]);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($this->uploadFiles($_FILES) as $file) {
                $files[] = [
                    'name' => $file['file_name'],
                    'size' => $file['file_size'],
                    'url' => Uri_helper::cdn($this->_module . '/' . $file['file_name']),
                    'thumbnailUrl' => Uri_helper::cdn($this->_module . '/' . $file['file_name']),
                    'deleteUrl' => Uri_helper::url('management/pm_issues/manage_files/') . '?file=' . $file['file_name'],
                    'deleteType' => 'DELETE'
                ];
            }
            return json_encode(['files' => $files]);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($id) {
                $model->pm_attachment_id = $id;
                $model->delete();
                echo '{"' . $this->input->get('file') . '":true}';
            } else
                echo '{"' . $this->input->get('file') . '":true}';
        }
    }

    private function uploadFiles($files)
    {
        $input_name = 'files';
        $config = array(
            'upload_path' => './cdn/' . $this->_module,
            'allowed_types' => '*',
        );
        $__files = array();
        for ($i = 0; $i < count($files[$input_name]['name']); $i++) {
            $_FILES[$input_name]['name'] = $files[$input_name]['name'][$i];
            $_FILES[$input_name]['type'] = $files[$input_name]['type'][$i];
            $_FILES[$input_name]['tmp_name'] = $files[$input_name]['tmp_name'][$i];
            $_FILES[$input_name]['error'] = $files[$input_name]['error'][$i];
            $_FILES[$input_name]['size'] = $files[$input_name]['size'][$i];
            $this->upload->initialize($config);

            if ($this->upload->do_upload($input_name)) {
                $data = $this->upload->data();
                $__files[] = $data;
            } else {
                return 'ERROR';
            }
        }
        return $__files;
    }
}
