<?php

class Path
{

    private $path = [];

    public function __construct()
    {
        Log::set('Initialize Path class');
        $this->stdin();
        $this->path['self'] = pathinfo(__FILE__, PATHINFO_BASENAME);
        $this->path['styles'] = Brightery::pathBuilder([ROOT, 'styles']);
        $this->path['source'] = Brightery::pathBuilder([ROOT, 'source']);
        $this->path['system'] = Brightery::pathBuilder([$this->path['source'], SYSTEM_FOLDER]);
        $this->path['cdn'] = Brightery::pathBuilder([ROOT, 'cdn']);
        $this->path['application'] = Brightery::pathBuilder([$this->path['source'], 'app']);
        $this->path['controllers'] = Brightery::pathBuilder([$this->path['application'], 'controllers']);
        $this->path['models'] = Brightery::pathBuilder([$this->path['application'], 'models']);
        $this->path['helpers'] = Brightery::pathBuilder([$this->path['application'], 'helpers']);
        $this->path['system_helpers'] = Brightery::pathBuilder([$this->path['system'], 'helpers']);
        $this->path['libraries'] = Brightery::pathBuilder([$this->path['application'], 'libraries']);
        $this->pathConstants();
    }

    private function stdin()
    {
        // Set the current directory correctly for CLI requests
        if (defined('STDIN')) {
            chdir(dirname(__FILE__));
        }
    }

    private function checkPath($systemFolder = 'Brightery')
    {
        // Check if the system path correct?
        if (!is_dir(ROOT . DS . $systemFolder)) {
            header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
            echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
            exit(3);
        }
    }

    private function pathConstants()
    {
        foreach ($this->path as $key => $value) {
            define(strtoupper($key), $value);
        }
    }

    public function get($var)
    {
        switch ($var) {
            case "BASE":

                break;
            case "SOURCE":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

            case "":

                break;

        }

    }


}