<?php

/**
 * Management application styles and interfaces
 * @package Brightery CMS
 * @version 1.0
 * @property object $instance Codeigniter instance
 * @property string $interface User Interface name
 * @property string $styleName Style name
 * @property string $styleAssets Style assets path
 * @property string $stylePath Style path
 * @property string $styleUri Style URI
 * @property string $styleDirection Style Direction
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 * 
 */
class Style {

    private $instance;
    private $interface;
    private $styleName;
    private $styleAssets;
    private $styleUri;
    private $styleDirection;
    public $stylePath;

    public function __construct() {
        Log::set('Initialize Style class');
        $this->instance = & Brightery::SuperInstance();
        $this->initialize();
    }

    private function initialize() {
        $this->interface = $this->instance->Twig->interface;
        $this->styleName = $this->instance->Twig->styleName;
        $this->styleDirection = $this->instance->language->getLanguageDirection();
        $this->stylePath = ROOT . '/styles/' . $this->interface . '/' . $this->styleName;
        $this->styleUri = BASE_URL . 'styles/' . $this->interface . '/' . $this->styleName;
        if (!is_dir($this->stylePath))
            Brightery::error_message($this->stylePath . " is missed.");
        $this->parsing();
        $this->createStyleConstants();
    }

    private function parsing() {
        $style_ini = $this->stylePath . '/style.ini';
        if (!file_exists($style_ini))
            Brightery::error_message($style_ini . " is missed.");
        $this->styleAssets = parse_ini_file($style_ini, true);
    }

    private function createStyleConstants() {
        $settings = $this->styleAssets[$this->styleDirection];
        define('STYLE_IMAGES', $this->styleUri . '/assets/' . $settings['images']);
        define('STYLE_JS', $this->styleUri . '/assets/' . $settings['js']);
        define('STYLE_CSS', $this->styleUri . '/assets/' . $settings['css']);
        define('MODULE_URL', BASE_URL . 'source/app/modules/');
    }

}
