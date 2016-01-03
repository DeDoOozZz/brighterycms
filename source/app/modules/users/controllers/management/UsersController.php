<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Users
 * @package Brightery CMS
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 * @version 1.0
 * @interface management
 * @module users
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/users
 * @controller UsersController
 *
 * */
class UsersController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('users');
    }

    public function indexAction() {
        $this->permission('index');
        $model = new \modules\users\models\Users();
        $model->_select = "user_id, image, fullname, email ,gender, (SELECT `resumes`.`resume_id` FROM resumes WHERE `resumes`.`user_id` = `users`.`user_id`) AS resume_id";
        return $this->render('users/index', [
                    'items' => $model->get()
        ]);
    }

    public function manageAction($id = false) {
        $redirect = "management/users";
        $this->permission('manage');
//        $model = new Users('register');
        if ($id) {
            $model = new \modules\users\models\Users('edit');
            $model_phone = new \modules\users\models\User_phones('edit');
            $model_phone->_select = 'user_phone_id ,phone';
            $model_phone->user_id = $id;
//            $model_phone->status = 'active' ;
            $res = $model_phone->get();
            $user_phone_id = $res[0]->user_phone_id;
            $model_phone->user_phone_id = $user_phone_id;
        } else {
            $model = new \modules\users\models\Users('add');
            $model_phone = new \modules\users\models\User_phones('add');
        }
        if ($_POST) {
            $model->attributes['fullname'] = $this->input->post('fullname');
            $model->attributes['usergroup_id'] = $this->input->post('usergroup_id');
            $model->attributes['email'] = $this->input->post('email');
            $model->attributes['gender'] = $this->input->post('gender');
        }
        if ($this->input->post('password') != '')
            $model->attributes['password'] = md5($this->input->post('password'));
        //////////////////////////////////UserGroup/////////////////////////////
        $usergroups = Form_helper::queryToDropdown('usergroups', 'usergroup_id', 'name');
        if ($id) {
            $model->user_id = $id;
            $model_phone->user_id = $id;
        }

        $model_phone->phone = $this->input->post('phone');
        $model->language_id = $this->language->getDefaultLanguage(); //?
        if (!$id) {
            if ($_POST) {
                $model->created = date("Y-m-d H:i:s");
            }
        }
        if ($r = $model->save()) {

            $model_phone->attributes['phone'] = $this->input->post('phone');
            $model_phone->attributes['user_id'] = $r;
            $model_phone->save();
            if ($this->input->get('url'))
                $redirect = $this->input->get('url') . $r;
            Uri_helper::redirect($redirect);
        } else
            return $this->render('users/manage', [
                        'item' => $id ? $model->get() : null,
                        'menu' => ['male' => 'Male', 'female' => 'Female'],
                        'usergroup' => $usergroups,
                        'phone' => $model_phone->get()
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\users\models\Users();
        $model->user_id = $id;
//
//        $model_resume = new \modules\resumes\models\Resumes();
//        $model_resume->_select = 'resume_id';
//        $model_resume->user_id = $id;
//        $resume = $model_resume->get();
//        $resume_id = $resume[0]->resume_id;
//        $model_resume->resume_id = $resume_id;
//        $model_phone = new \modules\users\models\user_phones();
//        $model_phone->user_id = $id;
//        $model_activities = new modules\resumes\models\Resume_activities();
//        $model_activities->resume_id = $resume_id;
//        $model_contacts = new modules\resumes\models\Resume_contacts();
//        $model_contacts->resume_id = $resume_id;
//        $model_details = new modules\resumes\models\Resume_details();
//        $model_details->resume_id = $resume_id;
//        $model_education = new modules\resumes\models\Resume_education();
//        $model_education->resume_id = $resume_id;
//        $model_hobbies = new modules\resumes\models\Resume_hobbies();
//        $model_hobbies->resume_id = $resume_id;
//        $model_languages = new modules\resumes\models\Resume_languages();
//        $model_languages->resume_id = $resume_id;
//        $model_locations = new modules\resumes\models\Resume_locations();
//        $model_locations->resume_id = $resume_id;
//        $model_skills = new modules\resumes\models\Resume_skills();
//        $model_skills->resume_id = $resume_id;
//        $model_work = new modules\resumes\models\Resume_work_history();
//        $model_work->resume_id = $resume_id;
        if ($model->delete()) {
//            $model_resume->delete();
//            $model_activities->delete();
//            $model_contacts->delete();
//            $model_details->delete();
//            $model_education->delete();
//            $model_hobbies->delete();
//            $model_languages->delete();
//            $model_locations->delete();
//            $model_skills->delete();
//            $model_work->delete();
//            $model_phone->delete();
            Uri_helper::redirect("management/users");
        }
    }

    public function loginAction($ajax = false) {
        $this->layout = 'ajax';
        if ($this->permissions->checkUserCredentials())
            Uri_helper::redirect("management/dashboard");

        $login = new \modules\users\models\Users('login');

        if ($ajax == 'ajax') {

            $resp = ['accessGranted' => false, 'errors' => '', 'redirect' => '']; // For ajax response

            if ($login->validate()) {
                $resp['accessGranted'] = true;
                $resp['redirect'] = Uri_helper::url('management/dashboard');
                $this->input->cookie('failed-attempts', 0);
                $userInfo = $this->permissions->getUserInformation();
                $this->input->cookie('fullname', $userInfo->fullname);
                $this->input->cookie('email', $userInfo->email);
                $this->input->cookie('password', $userInfo->password);
                $this->input->cookie('image', $userInfo->image);
            } else {
                // Failed Attempts
                $fa = $this->input->cookie('failed-attempts') ? $this->input->cookie('failed-attempts') : 0;
                $fa++;

                $this->input->cookie('failed-attempts', $fa);

                // Error message
                $resp['errors'] = $this->Language->phrase('please_enter_a_valid_email_and_password') . $fa;
            }

            echo json_encode($resp);
        } else
            return $this->render('users/login');
    }

    public function logoutAction() {
        $this->input->deleteCookie('email');
        $this->input->deleteCookie('fullname');
        $this->input->deleteCookie('password');
        Uri_helper::redirect('management');
    }

    public function forgot_passwordAction() {
//        $this->load->model('blog_posts_model');
//        $data['data'] = ($this->blog_posts_model->get());
//        $this->load->template("home/index", $data);
//        redirect('management/account/login');
    }

}
