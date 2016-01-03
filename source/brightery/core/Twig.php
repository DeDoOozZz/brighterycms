<?php

class Twig
{
    public $twig;
    public $layout = "default";
    public $layoutParams = [];
    public $interface = 'frontend';
    public $styleName = 'default';
    private $stylePath;

    public function __construct()
    {
        Log::set('Initialize Twig class');
        require_once SYSTEM . '/core/twig/vendor/autoload.php';
    }

    /**
     * Render
     * @param string $template
     * @param array $params
     * @return mixed
     */
    public function render($template, $params = [])
    {
        if (!$this->twig) {
            $this->stylePath = STYLES . '/' . $this->interface . '/' . $this->styleName . '/';
            $this->moduleStylePath = APPLICATION . '/' . 'modules' . '/' . Brightery::$RunningModule . '/' . 'views' . '/' . $this->interface . '/';
            $viewPath[] = ROOT;
            // CHECK IF THERE'S A MAIN TEMPLATE
            if ($base = file_exists($this->stylePath . $template . '.twig')) {
                $viewPath[] = $this->stylePath;
            }

            if ($modules = file_exists($this->moduleStylePath . $template . '.twig')) {
                $viewPath[] = $this->moduleStylePath;
            }

            if (!$modules && !$base) {
                Brightery::error_message("The view file " . $template . " doesn't exist.");
            }

            $loader = new Twig_Loader_Filesystem($viewPath);
            $this->twig = new Twig_Environment($loader, ['autoescape' => false]);
            $this->twig->addExtension(new Twig_Extension_Text());
            $this->twig->addExtension(new Twig_Extension_Debug());
            $this->twig->addFilter(new Twig_SimpleFilter('cast_to_array', function ($stdClassObject) {
                $response = [];
                foreach ($stdClassObject as $key => $value) {
                    $response[$key] = $value;
                }
                return $response;
            }));
        }
        $params = array_merge($params, $this->layoutParams);
        $layout = $this->twig->render('styles/'.$this->interface . '/' . $this->styleName . '/layout/' . $this->layout . '.twig', $params);
        return str_replace("{layout}", $this->twig->render($template . '.twig', $params), $layout);
    }
}

