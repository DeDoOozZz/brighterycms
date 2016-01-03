<?php

class Helper {

    private $helpers;

    public function __call($class, $arguments) {
        $class = ucfirst($class) . "_helper";
        if (!isset($this->helpers[$class]))
            $this->helpers[$class] = new $class();
        return $this->helpers[$class];
    }

}
