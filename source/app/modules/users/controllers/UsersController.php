<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Users
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 * @version 1.0
 * @interface frontend
 * @module users
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/users
 * @controller UsersController
 *
 * */
class UsersController extends Brightery_Controller
{

    protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load('users');
    }

    public function indexAction()
    {
        Uri_helper::redirect("users/register");
    }

    public function registerAction()
    {
        $model = new \modules\users\models\Users('register');
        $user_phone = new \modules\users\models\User_phones(false);
        $user_address = new \modules\users\models\User_addresses(false);

        $model->set('usergroup_id', 1);
        $model->set('fullname', $this->input->post('fullname'));
        $model->set('usergroup_id', $this->input->post('usergroup_id'));
        $model->set('email', $this->input->post('email'));
        $model->set('gender', $this->input->post('gender'));
        $model->set('password', md5($this->input->post('password')));
        $model->set('status', 'active');

        if ($r = $model->save()) {
            foreach ($this->input->post('phone') as $phone) {
                $user_phone->set('phone', $phone);
                $user_phone->set('user_id', $r);
                $user_phone->save();
            }
            foreach ($this->input->post('address') as $address) {
                $user_address->set('address', $address);
                $user_address->set('user_id', $r);
                $user_address->set('type', 'shipping');
                $user_address->save();
            }
            Uri_helper::redirect("users/thankyou");
        } else
            return $this->render('users/register', [
                'menu' => ['male' => 'Male', 'female' => 'Female'],
            ]);
    }

    public function thankyouAction()
    {
        return $this->render('users/thankyou');
    }

    public function loginAction($ajax = false)
    {
        $this->layout = 'ajax';
        $login = new \modules\users\models\Users('login');

        $resp = ['accessGranted' => false, 'errors' => '', 'redirect' => '']; // For ajax response

        if ($login->validate()) {
            $resp['accessGranted'] = true;
            $resp['redirect'] = Uri_helper::url();
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

        return json_encode($resp);
    }

    public function logoutAction()
    {
        $this->input->deleteCookie('email');
        $this->input->deleteCookie('fullname');
        $this->input->deleteCookie('password');
        Uri_helper::redirect();
    }

    public function forgot_passwordAction()
    {
//        $this->load->model('blog_posts_model');
//        $data['data'] = ($this->blog_posts_model->get());
//        $this->load->template("home/index", $data);
//        redirect('management/account/login');
    }

}
