<?php

/**
 * Brightery Loader
 *
 * @package Brightery CMS
 * @version 1.0
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 */
class Loader extends Brightery
{
    /**
     * Loader Constructor
     */
    public function __construct()
    {
        Brightery::$instance = &$this;
        define('SYSTEM_PATH', ROOT . '/' . SOURCE_FOLDER . '/' . SYSTEM_FOLDER);
        define('APPLICATION_PATH', ROOT . '/' . SOURCE_FOLDER . '/' . APPLICATION_FOLDER);
        define('MODULES_PATH', APPLICATION_PATH . '/modules');

    }

    private function loadCoreFiles()
    {
        foreach ($this->_core as $core => $instance) {
            $this->importFile(SYSTEM_PATH . '/core/' . $core . '.php');

            if ($inherited = file_exists($extension = APPLICATION_PATH . '/core/' . self::$configurations['Config']['core_extension_prefix'] . $core . '.php'))
                $this->importFile($extension);

            if (!empty($instance))
                $this->_queue[] = [
                    'class' => $inherited ? self::$configurations['Config']['core_extension_prefix'] . $core : $core,
//                    'params' => isset(self::$configurations[$core]) ? self::$configurations[$core] : null,
                    'InstanceName' => $instance
                ];
        }
    }

    private function loadLibraries()
    {
        $libraries = Brightery::$configurations['Autoload']['libraries'];
        $this->_libraries = glob(SYSTEM_PATH . '/libraries/*.php');
        array_walk_recursive($this->_libraries, function (&$value, $key) {
            $value = $this->_getFileName($value);
        });

        for ($i = 0; $i < count($libraries); $i++) {
            if (in_array($libraries[$i], $this->_libraries)) {
                // SYSTEM LIBRARY
                $this->importFile(SYSTEM_PATH . '/libraries/' . $libraries[$i] . '.php');

                if ($inherited = file_exists($extension = APPLICATION_PATH . '/libraries/' . self::$configurations['Config']['core_extension_prefix'] . $libraries[$i] . '.php'))
                    $this->importFile($extension);

                $this->queue($inherited ? self::$configurations['Config']['core_extension_prefix'] . $libraries[$i] : $libraries[$i], [], $libraries[$i]);
            } else {
                // CUSTOM LIBRARY
                if (file_exists($extension = APPLICATION_PATH . '/libraries/' . $libraries[$i] . '.php'))
                    $this->importFile($extension);
                else
                    return Brightery::error_message("Can't find the library file " . $libraries[$i]);
                $this->queue($libraries[$i], [], $libraries[$i]);
            }

        }
    }

    /**
     * Load Configuration files
     */
    private function loadConfigurations()
    {
        $files = array_merge(glob(APPLICATION_PATH . '/config/*.php'), glob(APPLICATION_PATH . '/modules/*/config/*.php'));
        for ($i = 0; $i < count($files); $i++) {
            $class = $this->_getFileName($files[$i]);
            if (file_exists($files[$i])) {
                Brightery::$loadedFiles[] = $files[$i];
                if (!isset(parent::$configurations[$class])) {
                    if (is_array($arr = require $files[$i]))
                        parent::$configurations[$class] = $arr;
                } else
                    if (is_array($arr = require $files[$i]))
                        parent::$configurations[$class] = array_merge_recursive(parent::$configurations[$class], $arr);
            }
        }
    }

    private function loadHelpers()
    {
        $helpers = Brightery::$configurations['Autoload']['helpers'];
        $this->_helpers = glob(SYSTEM_PATH . '/helpers/*.php');
        array_walk_recursive($this->_helpers, function (&$value, $key) {
            $value = str_replace([SYSTEM_PATH . '/helpers/', '.php'], '', $value);
        });

        for ($i = 0; $i < count($helpers); $i++) {
            if (in_array($helpers[$i], $this->_helpers)) {
                // SYSTEM LIBRARY
                $this->importFile(SYSTEM_PATH . '/helpers/' . $helpers[$i] . '.php');

                if ($inherited = file_exists($extension = APPLICATION_PATH . '/helpers/' . self::$configurations['Config']['core_extension_prefix'] . $helpers[$i] . '.php'))
                    $this->importFile($extension);

            } else {
                // CUSTOM LIBRARY
                if (file_exists($extension = APPLICATION_PATH . '/helpers/' . $helpers[$i] . '.php'))
                    $this->importFile($extension);
                else
                    return Brightery::error_message("Can't find the helper file " . $helpers[$i]);
            }

        }
    }

    public function bootstrap()
    {
        $this->loadConfigurations();
        $this->loadCoreFiles();
        $this->loadLibraries();
        $this->loadHelpers();
        $this->createInstances();
    }

    /**
     * Importing Files
     * @param type $file
     */
    private function importFile($file)
    {
        if (file_exists($file)) {
            Brightery::$loadedFiles[] = $file;
            require_once $file;
        } else
            return Brightery::error_message("Can't find the file " . $file, 'system');
    }

    /**
     * Get instance for each class in the queue
     * then kill the queue
     */
    private function createInstances()
    {
        for ($i = 0; $i < count($this->_queue); $i++) {
            $this->getInstance($this->_queue[$i]['class'], [], $this->_queue[$i]['InstanceName']);
        }
        unset($this->_queue);
    }


    /**
     * return object of the instance if it's intiated before and create once if doesn't exists
     *
     * @param string $class
     * @param array $params
     * @param string $instanceName
     * @return object
     */
    public function getInstance($class, $params = [], $instanceName = null)
    {
        // SPECIFY THE INSTANCE NAME
        if (!$instanceName)
            $instanceName = $class;

        // CHECK IF THE INSTANCE IS ALREADY AVAILABLE
        if (isset($this->$instanceName))
            return $this->$instanceName;

        // IF THERE'S A CONFIG FILE
        if (!$params && isset(Brightery::$configurations[$class]))
            $params = Brightery::$configurations[$class];

        // CREATE A NEW INSTANCE AND RETURN IT
        return $this->$instanceName = new $class($params);
    }

    /**
     * Get Class/File name from file path
     * @param string $file
     * @return string
     */
    private function _getFileName($file)
    {
        return trim(basename($file), '.php');
    }

    private function queue($class, $params = [], $instance = null)
    {
        if ($instance == null)
            $instance = $class;
        $this->_queue[] = [
            'class' => $class,
            'params' => $params,
            'InstanceName' => $instance
        ];
    }

    public function library($file, $instance = null)
    {
        $file = ucfirst($file);
        if (!$instance)
            $instance = $file;
        if (in_array($file, $this->_libraries)) {
            // SYSTEM LIBRARY
            $this->importFile(SYSTEM_PATH . '/libraries/' . $file . '.php');

            if ($inherited = file_exists($extension = APPLICATION_PATH . '/libraries/' . self::$configurations['Config']['core_extension_prefix'] . $file . '.php'))
                $this->importFile($extension);

            $this->getInstance($inherited ? self::$configurations['Config']['core_extension_prefix'] . $file : $file, [], $instance);
        } else {
            // CUSTOM LIBRARY
            if (file_exists($extension = APPLICATION_PATH . '/libraries/' . $file . '.php'))
                $this->importFile($extension);
            else
                return Brightery::error_message("Can't find the library file " . $file);
            $this->getInstance($file, [], $instance);
        }
    }


    /**
     * TODO: DEPRECATED FUNCTIONS BELOW
     */


    public function helper($class, $params = [])
    {
        in_array($class, $this->_helpers) ? $path = 'system' : $path = 'application';
        $this->importClass($class, $params, null, 'libraries', $path, 'static');
    }


    /**
     * Import a class file and list it in the queue
     *
     * @param string $class Origin class name
     * @param array $params Class Parameters
     * @param string $InstanceName Instance Nickname
     * @param string $type (core, libraries or helpers)
     * @param string $path (system or application)
     * @param string $method Options:
     *              'inherited' => could be extended from the application,
     *              'inherited-no-instance' => could be extended from the application, But don't take a place into the instance queue,
     *              'static' => don't take instance of it,
     *              'strict' => force to take an instace
     */
    private function importClass($class, $params = [], $InstanceName = null, $type = 'libraries', $path = 'application', $method = 'inherited')
    {
        $path = $this->buildClassPath($class, $type, $path);
        $this->importFile($path);
        if ($method != 'static')
            $this->_queue[] = [
                'class' => $class,
                'params' => $params,
                'type' => $type,
                'InstanceName' => $InstanceName,
                'method' => $method
            ];
    }

    /**
     * Build Class Path
     * @param string $class
     * @param string $type
     * @param string $path
     * @return string class full path
     */
    private function buildClassPath($class, $type, $path)
    {
        switch ($path) {
            case 'application':
                $classPath = APPLICATION_PATH . '/' . $type . '/' . $class . '.php';
                break;
            case 'system':
                $classPath = SYSTEM_PATH . '/' . $type . '/' . $class . '.php';
                break;
        }
        return $classPath;
    }


}
