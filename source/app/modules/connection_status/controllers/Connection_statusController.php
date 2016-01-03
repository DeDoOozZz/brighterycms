<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Connection Status
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module connection_status
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/connection_status
 * @controller Connection_statusController
 * */

class Connection_statusController extends Brightery_Controller
{
    protected $layout = 'ajax';

    public function indexAction()
    {
        return json_encode(['connected' => 1]);
    }
}

