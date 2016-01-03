<?php

class Assets
{
    private $autoload_css = [];
    private $css = [];
    private $autoload_js = [];
    private $js = [];
    private $config;

    function __construct()
    {
        Log::set("Initialize Assets Class");
        $this->config = &Brightery::SuperInstance()->Config;
    }

    function add($file_name, $storage = 'local', $module = 'global', $type = null, $loader = 'custom')
    {

        if (!$type || ($type != 'js' && $type != 'css'))
            $type = $this->getTypeFromFileName($file_name);
        $ctype = $type;
        if ($loader == 'autoload')
            $type = 'autoload_' . $type;
        if ($module == 'global')
            if ($storage == 'local')
                $this->{$type}[] = constant('STYLE_' . strtoupper($ctype)) . '/' . $file_name;
            else
                $this->{$type}[] = $file_name;
        else
            if ($storage == 'local')
                $this->{$type}[] = MODULE_URL . $module . '/assets/' . $ctype . '/' . $file_name;
    }

    function getTypeFromFileName($filename)
    {
        $type = null;
        if (strpos($filename, '.js') !== FALSE)
            $type = 'js';
        elseif (strpos($filename, '.css') !== FALSE)
            $type = 'css';
        return $type;
    }

    function get()
    {
        // GLOBAL ASSETS
        $interface = &Brightery::SuperInstance()->Twig->interface;
        foreach ($this->config->get('Autoload.assets.' . $interface . '.js') as $js) {
            if (!isset($js['module']))
                $js['module'] = 'global';
            $this->add($js['file'], $js['storage'], $js['module'], 'js', 'autoload');
        }
        foreach ($this->config->get('Autoload.assets.' . $interface . '.css') as $css) {
            if (!isset($css['module']))
                $css['module'] = 'global';
            $this->add($css['file'], $css['storage'], $css['module'], 'css', 'autoload');
        }
        $output = null;
        foreach (array_merge($this->autoload_css, $this->css) as $link) {
            $output .= "<link rel=\"stylesheet\" href=\"$link\" />\n";
        }

        foreach (array_merge($this->autoload_js, $this->js) as $link) {
            $output .= "<script src=\"$link\"></script>\n";
        }
        return $output;
    }

    function debug()
    {
        $js = array_merge($this->autoload_js, $this->js);
        $css = array_merge($this->autoload_css, $this->css);
        return [
            'js' => $js,
            'css' => $css
        ];
    }
}