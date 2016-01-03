<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Settings Controller
 *
 * @package Brightery CMS
 * @author Esraa Abd El-Rahim <esraa.ahmad@brightery.com>
 * @version 1.0
 * @interface management
 * @module pm
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pm
 * @controller SettingsController
 *
 **/
class Pm_settingsController extends Brightery_Controller
{
    protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load('pm_settings');
    }

    public function indexAction()
    {
        $this->permission('index');
        $settings = $this->module->getSettings($this->_module);
        $status = Form_helper::queryToDropdown('Pm_issue_statues', 'Pm_issue_statues_id', 'title');
        if ($this->validation->validate($this)) {
            $this->module->saveSettings($this->_module,
                [
                    'creation_status' => $this->input->post('creation_status'),
                    'start_status' => $this->input->post('start_status'),
                    'pause_status' => $this->input->post('pause_status'),
                    'done_status' => $this->input->post('done_status'),
                ]);

            Uri_helper::redirect('management/' . $this->_module .'/pm_settings');
        }

        else

        return $this->render('pm_settings/index', [
               'status' => $status,
                'setting' => $settings
            ]);
    }

    public function rules()
    {
        return [
            'all' => [
                'creation_status' => ['required'],
                'start_status' => ['required'],
                'pause_status' => ['required'],
                'done_status' => ['required'],
            ]
        ];
    }

    public function fields()
    {
        return [
            'default_creation_status' => 'default_creation_status',
            'default_start_status' => 'default_start_status',
            'default_pause_status' => 'default_pause_status',
            'default_done_status' => 'default_done_status',



        ];
    }
}