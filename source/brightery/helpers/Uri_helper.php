<?php

class Uri_helper
{
    public $base;

    static function url()
    {
        $url = func_get_args();
        if (is_array($url) && count($url))
            $url = implode('/', $url);
        else
            $url = null;
        return BASE_URL . Brightery::SuperInstance()->Language->getDefaultLanguage() . "/" . $url;
    }

    static function redirect($loc = null, $lang = null)
    {
        if ($lang === null)
            $lang = $_GET['lang'];
        if ($loc === null)
            $loc = '';
        header("Location: " . BASE_URL . $_GET['lang'] . "/" . $loc);
    }

    static function cdn()
    {
        $url = func_get_args();
        if (is_array($url) && count($url))
            $url = implode('/', $url);
        else
            $url = null;
        return BASE_URL . "cdn/" . $url;
    }

    static function current($lang = null)
    {
        if (!$lang)
            $lang = $_GET['lang'];
        return BASE_URL . $lang  . implode('/', (explode('/', $_SERVER['PATH_INFO'])));
    }


}