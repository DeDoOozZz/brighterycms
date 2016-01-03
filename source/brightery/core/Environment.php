<?php

/**
 * Environment Checker
 * @package    Brightery Framework
 * @author    Muhammad El-Saeed
 * @copyright    Copyright (c) 2014 - 2015, Brightery (http://brightery.com/)
 * @link    http://brightery.com
 * @since    Version 1.0.0
 *
 * ---------------------------------------------------------------
 * ERROR REPORTING
 * ---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
class Environment
{
    public function __construct()
    {
        Log::set('Initialize Environment class');
        $this->setup();
    }

    private function setup()
    {
        if (!defined('ENVIRONMENT'))
            define('ENVIRONMENT', $this->detect());
        switch (ENVIRONMENT) {
            case 'development':
                ini_set("display_errors", 1);
                error_reporting(E_ALL);
                break;

            case 'testing':

            case 'production':
                ini_set('display_errors', 0);
                error_reporting(0);
                break;

            default:
                header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
                echo 'The application environment is not set correctly.';
                exit(1); // EXIT_ERROR
        }
    }

    private function detect()
    {
        if ($_SERVER['HTTP_HOST'] == 'localhost' or strpos($_SERVER['HTTP_HOST'], '192.168.') !== FALSE) {
            return 'development';
        } else {
            return 'production';
        }
    }
}
