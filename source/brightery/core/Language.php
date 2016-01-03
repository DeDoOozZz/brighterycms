<?php

/**
 * Language class
 *
 * @package Brightery CMS
 * @version 1.0
 * @property object $instance Brightery instance
 * @property string $languagePath Language files path
 * @property array $languageConfiguration Language config file parsing results
 * @property int $language_id Language ID into the database
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 */
class Language
{
    private $instance;
//    private $supportedLanguages;
    private $languagePath;
    private $moduleLanguagePath;
    private $languageConfiguration;
    public $defaultLanguage = 'en';
    public $phrases = []; // Translated Phrases
    private $_setupStatus = false;

    public function __construct()
    {
        Log::set('Initialize Language class');
        $this->instance = &Brightery::SuperInstance();

        foreach ($this->instance->Config->get('Autoload.language') as $file)
            $this->load($file);
    }

    /**
     * SETUP LANGUAGE GLOBALS
     */
    protected function setupGlobals()
    {
        $this->languagePath = ROOT . '/languages/' . $this->getDefaultLanguage(true);
        $style_ini = $this->languagePath . '/language.ini';
        if (!file_exists($style_ini))
            if (ENVIRONMENT == 'development')
                Brightery::error_message($style_ini . " is missed.");
            else
                header("Location: " . BASE_URL .'en');

        $this->languageConfiguration = parse_ini_file($style_ini, true);
    }

    private function setupLanguage()
    {
        if ($this->_setupStatus)
            return;

        if (!in_array($this->instance->Input->get('lang'), $this->instance->Config->get('Language.support'))) {
            $_GET['lang'] = $this->instance->Config->get('Language.default');
            header("Location: " . BASE_URL . $_GET['lang']);
        }
        // IF LANGUAGE IS IN THE URL SET IT
        $this->defaultLanguage = $this->instance->input->get('lang');
        $this->setupGlobals();
        $this->_setupStatus = true;
    }

    public function getLanguageDirection()
    {
        if (isset($this->languageConfiguration['language_settings']['direction']))
            return $this->languageConfiguration['language_settings']['direction'];
    }

    /**
     * Get The Default Language
     * @return string
     */
    public function getDefaultLanguage()
    {
        if ($this->defaultLanguage)
            return $this->defaultLanguage;
        else
            return 'en';
    }

    /**
     * Load Language File
     * @param string $file file name without .php
     */
    public function load($file)
    {
        $this->setupLanguage();
        $this->moduleLanguagePath = APPLICATION . '/modules/*/languages/' . $this->getDefaultLanguage(true) . '/';

        if ($language_file = Brightery::loadFile($this->languagePath . "/$file.php", false, null, true))
            $this->phrases = array_merge($this->phrases, $language_file);

        foreach (glob(ROOT . '/' . SOURCE_FOLDER . '/' . APPLICATION_FOLDER . "/modules/*/languages/" . $this->getDefaultLanguage(true) . "/$file.php") as $lang_file) {
            $phrases = Brightery::loadFile($lang_file, false, null, true);
            $this->phrases = array_merge($this->phrases, $phrases);
        }
    }

    /**
     * Get the phrase of the $key index
     * @param string $key
     * @return string
     */
    public function phrase($key)
    {
        if (isset($this->phrases[$key]))
            return $this->phrases[$key];
        else
            return $key;
    }
}
