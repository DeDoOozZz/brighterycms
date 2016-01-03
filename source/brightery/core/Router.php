<?php

class Router
{
    private $route = [];
    private $headers;
    private $request;
    private $userAgent;
    public $segments;
    private $current;
    public $controllerPaths; // Paths of controllers [root, modules]
    private $replace = [
        '(:string)' => '([a-zA-Z0-9]+)',
        '(:int)' => '([0-9]+)',
        '/' => '\/',
    ];

    public function __construct()
    {
        Log::set('Initialize Router class');
        define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
        $this->route = Brightery::SuperInstance()->Config->get('Route');
        unset($this->route['default']);
        $this->controllerPaths = new stdClass();
        $this->controllerPaths->root = APPLICATION . '/controllers';
        $this->controllerPaths->modules = APPLICATION. '/modules/*/controllers';
//        $this->request = $this->app->request;
//        $this->headers = $this->app->request->headers;
//        $this->userAgent = $this->app->request->getUserAgent();
    }

    /**
     * START RUNNING THE ROUTE TRIP ...
     */
    public function run()
    {
        if (!$segments = trim($_SERVER['PATH_INFO'] ? $_SERVER['PATH_INFO'] :  $_SERVER['ORIG_PATH_INFO'], '/'))
            $this->segments = explode('/', trim(Brightery::SuperInstance()->Config->get('Route.default'), '/'));
        else
            $this->segments = explode('/', $segments);

        $this->current = implode('/', $this->segments);
        foreach ($this->route as $pattern => $real_route) {
            $pattern = "/^" . str_replace(array_keys($this->replace), array_values($this->replace), $pattern) . "$/";
            if (preg_match($pattern, $this->current, $match))
                $this->segments = explode('/', preg_replace($pattern, $real_route, $this->current));
        }
        return $this->detect();
    }

    /**
     * DETECT THE CURRENT ROUTE
     */
    public function detect()
    {
        // IT'S NOT THE DEFAULT ROUTE, FIND THE MENTIONED CONTROLLER
        $Route = $this->findController();

        if (!$Route)
            return Brightery::error404();

        if(preg_match("/".str_replace(['/', '*'], ['\\'. '/', '([a-zA-Z0-9_-]+)'], $this->controllerPaths->modules)."/", $Route['path'], $res)) {
            Brightery::$RunningModule = $res[1];
        }

        // MAKE INSTANCE
        require_once $Route['path'];
        $controllerInstance = new $Route['controller'];

        // GET ACTION TO RUN
        $method = isset($this->segments[$Route['method'] + 1]) ? $this->segments[$Route['method'] + 1] . "Action" : 'indexAction';
        if (!method_exists($controllerInstance, $method))
            return Brightery::error404();

        // GET PARAMS
        $params = array_slice($this->segments, $Route['method'] + 2, count($this->segments) - 1);
            
        // RUN
        echo call_user_func_array([$controllerInstance, $method], $params);
//        exit(200);
    }

    /**
     * SUGGEST THE AVAILABLE DIRECTORIES OF THE CONTROLLER, THEN CALL getController() METHOD
     * @return bool
     */
    public function findController()
    {
        if ($moduleResult = $this->getController($this->controllerPaths->modules))
            return $moduleResult;
        else
            return $this->getController($this->controllerPaths->root);

        return false;
    }

    /**
     * Search for the controller
     * @param $_path
     * @param $segment
     * @return array|bool
     */
    private function getController($_path = NULL, $segment = 0)
    {
        if (count($this->segments) - 1 < $segment)
            return false;

        if (isset($this->segments[$segment + 1])) {
            $suggestDirectories = glob($_path.'/'. $this->segments[$segment].'/'. ucfirst($this->segments[$segment + 1]) . "Controller.php");
            if ($suggestDirectories)
                return [
                    'controller' => ucfirst($this->segments[$segment + 1]) . 'Controller',
                    'method' => $segment + 1,
                    'path' => $suggestDirectories[0]
                ];
        }

        $suggestController = glob($_path .'/'. ucfirst($this->segments[$segment]) . "Controller.php");
        if ($suggestController)
            return [
                'controller' => ucfirst($this->segments[$segment]) . 'Controller',
                'method' => $segment,
                'path' => $suggestController[0]
            ];
        return false;
    }
}
