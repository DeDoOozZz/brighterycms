<?php

class Settings
{
    public function __construct()
    {
        foreach (Brightery::SuperInstance()->Database->query("SELECT `key`, `value` FROM settings")->result() as $setting) {
            Brightery::SuperInstance()->Config->set($setting->key, $setting->value);
        }
    }
}