<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Home Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module home
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/home
 * @controller HomeController
 *
 **/
class HomeController extends Brightery_Controller
{
    protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load($this->_module);
    }

    public function indexAction()
    {
        $this->permission('index');
        $settings = $this->module->getSettings($this->_module);
        if ($this->validation->validate($this)) {
            $this->module->saveSettings($this->_module, ['default_home_page' => $this->input->post('default_home_page')]);
            Uri_helper::redirect('management/' . $this->_module);
        } else
            return $this->render('home/index', [
                'home_pages' => Form_helper::arrayToDropdown($this->Config->get('Home')),
                'setting' => $settings
            ]);
    }

    public function rules()
    {
        return [
            'all' => [
                'default_home_page' => ['required']
            ]
        ];
    }

    public function fields()
    {
        return ['default_home_page' => 'default_home_page'];
    }
}