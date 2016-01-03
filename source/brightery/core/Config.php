<?php

class Config
{
    public function __construct()
    {
        Log::set('Initialize Config class');
    }

    public function get($item)
    {
        $item = explode('.', $item);
        $res = Brightery::$configurations;
        for ($i = 0; $i < count($item); $i++) {
            if (!isset($res[$item[$i]]))
                return null;
            $res = $res[$item[$i]];
        }
        return $res;
    }

    public function set($item, $value)
    {
        $item = explode('.', $item);
        for ($i = 0; $i < count($item); $i++) {
            Brightery::$configurations[$item[$i]] = $value;
        }
        return Brightery::$configurations;
    }
}