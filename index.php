<?php

/**
 * Brightery Framework
 * @package    Brightery Framework
 * @author    Muhammad El-Saeed
 * @copyright    Copyright (c) 2014 - 2015, Brightery (http://brightery.com/)
 * @link    http://brightery.com
 * @version    Version 1.0.0
 * Slim 2.6.2
 * Twig 1.18.0 (PHP 5.2.4)
 * Doctorine ORM 2.3.3
 */

//define('ENVIRONMENT', 'development');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (phpversion() < 5.4) {
    die("Sorry, You must have PHP 5.4 or later to use Brightery software");
}
/*
 * --------------------------------------------------------------------
 * DEFINE REQUIRED CONSTANTS
 * --------------------------------------------------------------------
 */
define('ROOT', str_replace('\\', '/', dirname(__FILE__)));
define('VERSION', '1.0');

/*
 * ---------------------------------------------------------------
 * SOURCE FOLDER NAME 
 * ---------------------------------------------------------------
 */
define('SOURCE_FOLDER', 'source');

/*
 * ---------------------------------------------------------------
 * APPLICATION FOLDER NAME 
 * ---------------------------------------------------------------
 */
define('APPLICATION_FOLDER', 'app');

/*
 * ---------------------------------------------------------------
 * SYSTEM FOLDER NAME 
 * ---------------------------------------------------------------
 */
define('SYSTEM_FOLDER', 'brightery');

/**
 * ---------------------------------------------------------------
 * EXTENDED CLASSES PREFIX (CORE, LIBRARIES OR HELPERS)
 * ---------------------------------------------------------------
 */
define('EXTENDED_CLASSES_PREFIX', 'Brightery_');

/**
 * ---------------------------------------------------------------
 * GET THE BASE URL
 * ---------------------------------------------------------------
 */

if (!isset($_SERVER['HTTP_HOST']) && $argv) {
    $_SERVER['HTTP_HOST'] = '/localhost';
    $arr = $argv;
    array_shift($arr);
    $_SERVER['PATH_INFO'] = '/' . implode('/', $arr);
    define('CMD_MODE', true);
} else {
    define('CMD_MODE', false);
}
define('BASE_URL', str_replace("/index.php", '', '//' . $_SERVER['HTTP_HOST'] . substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])))));


/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 */

require_once(ROOT . '/' . SOURCE_FOLDER . '/' . SYSTEM_FOLDER . '/core/Brightery.php');
