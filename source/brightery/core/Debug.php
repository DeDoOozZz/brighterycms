<?php

class Debug
{

    public function __construct()
    {
        Log::set('Initialize Debug class');
        if (ENVIRONMENT == 'development')
            if ((! isset($_SERVER['HTTP_X_REQUESTED_WITH']) or $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') && !CMD_MODE)
                $this->displayDebugger();
    }

    public function displayDebugger()
    {
        $data['memory'] = $this->getMemory();
        $data['brightery_version'] = $this->getFrameworkVersion();
        $data['php_version'] = $this->getPhpVersion();
        $data['status_code'] = $this->getStatusCode();
        $data['route'] = $this->getRoute();
        $data['execution_time'] = $this->getExecutionTime();
        $data['config'] = $this->getConfiguration();
        $data['queries'] = $this->getDatabase();
        $data['phpinfo'] = $this->getPHPinfo();
        $data['mac_address'] = $this->getMacAddress();
        $data['db_connection'] = $this->getCurrentConnections();
        $data['log'] = Log::get();
        $data['assets'] = $this->getAssets();
        return Brightery::loadFile([ROOT, 'styles', 'system', 'debug.php'], false, $data);
    }

    public function getFrameworkVersion()
    {
        return VERSION;
    }

    public function getPhpVersion()
    {
        return phpversion();
    }

    public function getStatusCode()
    {
        return http_response_code();
    }

    public function getRoute()
    {
        return implode('/', Brightery::SuperInstance()->Router->segments);
    }

    public function getExecutionTime()
    {
        return BRIGHTERY_END_TIME - BRIGHTERY_BEGIN_TIME;
    }

    public function getMemory()
    {
        $mem_usage = memory_get_usage(TRUE);
        if ($mem_usage < 1024)
            return $mem_usage . " Bytes";
        elseif ($mem_usage < 1048576)
            return round($mem_usage / 1024, 2) . " KB";
        else
            return round($mem_usage / 1048576, 2) . " MB";
    }

    public function getConfiguration()
    {
        return Brightery::$configurations;
    }

    public function getPHPinfo()
    {
        ob_start();
        phpinfo();
        $pinfo = ob_get_contents();
        ob_end_clean();
        $pinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);
        return $pinfo;
    }

    public function getDatabase()
    {
        return Brightery::SuperInstance()->Database->getQueryLog();
    }

    public function getCurrentConnections()
    {
        return Brightery::SuperInstance()->Database->getCurrentConnection();
    }

    public function getAssets()
    {
        return Brightery::SuperInstance()->Assets->debug();
    }

    public function getMailMessages()
    {

    }

    public function getLogs()
    {

    }

    public function getMacAddress()
    {
        return Brightery::SuperInstance()->license->_get_mac_address();
    }

    public function getDefinedVariables()
    {
//        return $GLOBALS;
        return get_defined_vars();
    }

    public function getDefinedConstants()
    {
        return get_defined_constants();
    }

    public function getDefinedFunctions()
    {
        return get_defined_functions();
    }
}