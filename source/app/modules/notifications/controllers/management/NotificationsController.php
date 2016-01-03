<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Categories Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module notifications
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/categories
 * @controller Notifications
 *
 **/

class NotificationsController extends Brightery_Controller
{
    protected $interface = 'management';
    protected $layout = 'ajax';

    public function getAction($notification_id = false)
    {
        $this->permission('index');
        $model = new \modules\notifications\models\Notifications();

    }
}

