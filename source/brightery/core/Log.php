<?php


class Log {
    public static $log;

    public static function set($message, $time = null) {
        if( ! $time)
            $time = microtime();
        self::$log[$time] = $message;
    }

    public static function get() {
        return self::$log;
    }
}