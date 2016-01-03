<?php


class Controller
{
    protected $interface;
    protected $layout;
    protected $layoutParams;
    protected $_data;

    public function __construct()
    {
        Log::set('Initialize Controller class');
        spl_autoload_register('Controller::__autoload');
    }

    public static function __autoload($classname)
    {
            $filename = $classname . ".php";
            if (strpos($classname, "Controller") !== false) {
                // TODO: CHECK MODULES CONTROLLERS

                // LOAD ROOT CONTROLLER
                Brightery::loadFile([CONTROLLERS, $filename]);

            } elseif (strpos($classname, "_helper") !== false) {
                $helper_path = HELPERS .'/'. ucfirst($filename);
                if (file_exists($helper_path))
                    Brightery::loadFile($helper_path);
                else
                    Brightery::loadFile(SYSTEM_HELPERS .'/'. ucfirst($filename));
            } // MODELS VIA NAMESPACE
            elseif (strpos($classname, "models") !== false) {
                $model_path = APPLICATION .'/'. str_replace('\\', '/', lcfirst($filename));
                if (file_exists($model_path))
                    Brightery::loadFile($model_path);
            } else {
                if (Brightery::$RunningModule) {
                    Brightery::loadFile(APPLICATION . '/modules/'. Brightery::$RunningModule. '/models/'. ucfirst($filename));
                } else {
                    Brightery::loadFile([MODELS, ucfirst($filename)]);
                }
            }
    }

    /**
     * __get magic
     *
     * return super instance's objects
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        $SI = &Brightery::SuperInstance();
        return $SI->$key;
    }

    /**
     * RENDER
     */
    public function render($view, $params = [])
    {
        if (isset(Brightery::SuperInstance()->Language)) {
            $params['lang'] = &Brightery::SuperInstance()->Language->phrases;
        }

        // CHECK THE REQUEST TYPE
        if ($this->input->get('api')) {
            // API RESPONSE
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');

            if (Brightery::SuperInstance()->Validation->errors())
                $params['error'] = Brightery::SuperInstance()->Validation->errors_array();
            return json_encode($params);
        } else {
            $params['config'] = &Brightery::SuperInstance()->Config;
            $params['input'] = &Brightery::SuperInstance()->input;
            $params['helper'] = &Brightery::SuperInstance()->Helper;
            if (Brightery::SuperInstance()->Validation->errors())
                $params['error'] = Brightery::SuperInstance()->Validation->errors();
            $params['debug'] = new tdebug();
            // NORMAL RESPONSE
            if ($this->interface)
                $this->Twig->interface = $this->interface;
            if ($this->layout)
                $this->Twig->layout = $this->layout;
            if ($this->Menu)
                $params[$this->interface . '_menu'] = $this->Menu->getMenu($this->interface);
            if ($this->_data)
                $params['_data'] = $this->_data;

            Brightery::$load->getInstance('Style');
            $params['assets'] = $this->Assets;
            $this->Twig->layoutParams = $this->layoutParams;
            return $this->Twig->render($view, $params);
        }
    }
}

class tdebug
{
    function var_dump($obj)
    {
        var_dump($obj);
    }

    function print_r($obj)
    {
        print_r($obj);
    }
}

