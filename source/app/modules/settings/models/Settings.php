<?php namespace modules\settings\models;
defined('ROOT') OR exit('No direct script access allowed');

/**
 * Settings Model
 * @package Brightery CMS
 * @author
 * @version 1.0
 **/
class  Settings extends \Model
{
    public $_table = 'settings';
    public $_fields = [
        'key' => ['varchar', 100, 'PRI'],
        'value' => ['varchar', 255],
        'default_value' => ['varchar', 255],
        'required' => ['tinyint', 1],
    ];


    public function rules()
    {
        return [
            'all' => [
                'title' => ['required'],
                'description' => ['required'],

            ],
        ];
    }


    public function fields()
    {
        return [
            'value' => 'value',
            'default_value' => 'default_value',
            'required' => 'required',
        ];
    }

    public function getAvailableStyles($interface = 'management')
    {
        $styles = [];
        foreach (scandir($path = STYLES . '/' . $interface) as $dir) {

            if (is_dir($path . '/' . $dir) && ($dir !== '.' && $dir !== '..') && file_exists($ini_file = $path . '/' . $dir . '/style.ini')) {
                $parser = parse_ini_file($ini_file);
                $styles[$dir] = $parser['name'];
            }
        }
        return $styles;
    }

    public function getAvailableLayouts($interface = "management", $style = "default")
    {
        $layouts = [];
        $path = STYLES . "/$interface/$style/layout/";

        foreach (glob($path . '*') as $dir) {
            $layouts[str_replace($path, '', $dir)] = str_replace([$path, '.twig'], '', $dir); //$path['name'];
        }

        $moduelsPath = MODULES_PATH . "/*/views/$interface/layout/*";

        foreach (glob($moduelsPath) as $dir) {
            $pattern =  str_replace(['*', '/'], ['([a-zA-Z0-9_.]+)', '\/'], $moduelsPath) ;
            preg_match('/'.$pattern.'/', $dir, $match);
            $layouts[] = $match[1].'/'.$match[2];
        }
        return $layouts;
    }
}
 