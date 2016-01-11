<?php defined('BRIGHTERY_BEGIN_TIME') or define('BRIGHTERY_BEGIN_TIME', microtime(true));
/**
 * Brightery Bootstrap
 *
 * @package Brightery CMS
 * @version 1.0
 * @link http://www.brightery.com
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 */
class Brightery
{
    /**
     * Loaded Files Log
     * @var array $loadedFiles
     */
    public static $configurations = [];
    /**
     * Loaded Files
     * @var array $loadedFiles
     */
    protected static $loadedFiles = [];

    /**
     * Native Core Classes
     * @var array $_core
     */
    protected $_core = [
        'Log' => '',
        'Optimizer' => '',
        'Path' => 'Path',
        'Environment' => 'Environment',
        'Config' => 'Config',
        'Input' => 'Input',
        'Router' => 'Router',
        'Helper' => 'Helper',
        'Twig' => 'Twig',
        'License' => 'License',
        'Controller' => '',
        'Model' => '',
        'Language' => 'Language',
        'Validation' => 'Validation',
        'Style' => '',
        'Upload' => 'Upload'

    ];
    /**
     * Native Libraries Classes
     * @var array $_libraries
     */
    protected $_libraries; // Native libraries
    protected $_helpers; // Native Helpers
    protected $_queue = []; // Queue

    /**
     * Super Instance (Singleton Design Pattern)
     * @var array $instance
     */
    protected static $instance;
    public static $load;
    public static $RunningModule = NULL;

    /**
     * Singleton Design Pattern
     *
     * @return static $instance
     */
    public static function & SuperInstance()
    {
        return self::$instance;
    }

    /**
     * Get a predefined class
     * @param $obj
     * @return mixed
     */
    public function __get($obj)
    {
        if (isset(self::$instance->{ucfirst($obj)}))
            return self::$instance->{ucfirst($obj)};
    }

    /**
     * Error 404
     */
    public static function error404()
    {
        self::loadFile(ROOT . '/styles/system/404.php');
        exit(404);
    }

    public static function pathBuilder($array)
    {
        return implode('/', $array);
    }

    public static function loadFile($path, $multiple = false, $data = null, $return_status = false)
    {
        if ($data)
            extract($data);

        if (is_array($path))
            $path = self::pathBuilder($path);

        if (!file_exists($path))
            if ($return_status)
                return false;
            else
                return self::error_message("Couldn't find the file " . $path);

        if (in_array($path, Brightery::$loadedFiles))
            if (!$multiple)
                return;

        Brightery::$loadedFiles[] = $path;
        return require $path;
    }

    public static function error_message($message, $status = 500, $handler = 'Application')
    {
        ob_start();
        self::loadFile([ROOT, 'styles', 'system', 'error.php']);
        $output = str_replace([
            '{handler}',
            '{message}'
        ], [
            $handler,
            $message
        ], ob_get_contents());
        ob_end_clean();
        echo $output;
        exit($status);
    }

    /**
     * Main function of the framework to run
     */
    public static function main()
    {
        /**
         * LOADING IMPORTANT LIBRARIES
         */
        require_once ROOT . '/' . SOURCE_FOLDER . '/' . SYSTEM_FOLDER . '/core/Error.php';
        require_once ROOT . '/' . SOURCE_FOLDER . '/' . SYSTEM_FOLDER . '/core/Optimizer.php';
        require_once ROOT . '/' . SOURCE_FOLDER . '/' . SYSTEM_FOLDER . '/core/Loader.php';
        require_once ROOT . '/' . SOURCE_FOLDER . '/' . SYSTEM_FOLDER . '/core/Debug.php';

        $error = new Error();
        $error->register();

        /**
         * INITIATE THE LOADER
         */

        self::$load = new Loader();

        self::$instance->Load = self::$load;
        /**
         * LOAD CORE SYSTEM LIBRARIES
         */
        self::$load->bootstrap(); //loadBrighteryCore();

        /**
         * CHECK THE LICENSE
         */
//        if (!CMD_MODE)
//            self::SuperInstance()->license->check_license();

        /**
         * LOAD LIBRARIES
         */
        //$Loader->loadLibraries();
        return self::$load->Router->run();
    }
}

/**
 * Run ...
 */
Brightery::main();

define('BRIGHTERY_END_TIME', microtime(true));

/**
 * Debugger
 */
if (! isset($_SERVER['HTTP_X_REQUESTED_WITH']) or (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') && ENVIRONMENT == 'development') {
    new Debug();
}



