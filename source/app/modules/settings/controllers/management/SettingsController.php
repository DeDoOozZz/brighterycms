<?php defined('ROOT') OR exit('No direct script access allowed');
/**
 * Settings
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module settings
 * @category general
 * @module_version  1.0
 * @link http://store.brightery.com/module/general/settings
 * @controller SettingsController
 * */
class SettingsController extends Brightery_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->language->load('settings');
    }

    public function indexAction()
    {
        $this->permission('index');

        $model = new \modules\settings\models\Settings();
        $model->_order_by = false;
        if (REQUEST_METHOD == 'POST') {
            foreach ($_POST as $key => $value) {
                $model->key = $key;
                $model->set('value', $value);
                $model->save();
            }
        }

        $model->reset();
        $items = $model->get();

        foreach ($items as $item) {
            $arr[$item->key] = $item->value;
        }


        return $this->render('settings/index', [
            'item' => $arr,
            'timezones' => array_combine (\DateTimeZone::listIdentifiers(), \DateTimeZone::listIdentifiers()),
            'management_styles'=> $model->getAvailableStyles('management'),
            'frontend_styles'=> $model->getAvailableStyles('frontend'),
            'frontend_layouts'=> $model->getAvailableLayouts('frontend', $this->config->get('frontend_style')),
            'management_layouts'=> $model->getAvailableLayouts('management', $this->config->get('management_style')),
        ]);
    }

    public function get_layoutsAction($interface = false, $style = false) {
        if(!$interface || !$style)
            return Brightery::error404();
        $this->layout = 'ajax';
        $model = new \modules\settings\models\Settings();


        foreach($model->getAvailableLayouts($interface, $style) as $key => $value)
            echo "<option value=\"$key\">". $value . "</option>";

    }
}
