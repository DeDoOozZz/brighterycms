<?php

class Brightery_Controller extends Controller
{
    // MODULE RAW-NAME
    protected $_module;
    protected $_controller;
    // MODULE VERSION
    protected $version = 1.0;
    protected $assets = null;
    protected $layoutParams;

    public function __construct()
    {
        parent::__construct();

        if (Brightery::SuperInstance()->Config->get('Config.elite_session'))
            $this->Input->eliteSession();

        // CONFIGURATIONS
        foreach ($this->database->query("SELECT * FROM `settings`")->result() as $setting){
            if($setting->key == 'timezone'){
                date_default_timezone_set($setting->value);
            }
            else
            {
                Brightery::SuperInstance()->Config->set($setting->key, $setting->value);

            }
        }


        $doc = new ReflectionClass($this);
        $docs = [];
        preg_match_all("/@([a-zA-Z]+) ([a-zA-Z0-9_\/.\- ]+)/", $doc->getDocComment(), $res, PREG_SET_ORDER);
        for ($i = 0; $i < count($res); $i++) {
            $docs[$res[$i][1]] = $res[$i][2];
        }
        if (isset($docs['module']))
            $this->_module = $docs['module'];
        if (isset($docs['version']))
            $this->version = $docs['version'];
        if (isset($docs['interface']))
            $this->interface = $docs['interface'];
        if (isset($docs['module']))
            $this->_module = $docs['module'];
        if (isset($docs['controller']))
            $this->_controller = $docs['controller'];

        Brightery::$RunningModule = $this->_module;

        $this->layoutParams['languages'] = $this->database->query("SELECT * FROM `languages`")->result();
//        if($user = $this->permissions->getUserInformation())
//        $this->layoutParams['notifications'] = $this->database->query("SELECT * FROM `notifications` WHERE user_id = '$user->user_id'")->result();
        if (function_exists($this->_module))
            $this->_data = call_user_func($this->_module);
//        if($this->_module == 'commerce'){
//            $cat_model = new \modules\commerce\models\Commerce_categories();
//            $this->load->library('cart');
//            $this->_data = array('categories' => $cat_model->tree(), 'cart' => $this->cart);
//        }
    }

    protected function permission($action = null)
    {
        if (!$this->permissions->checkUserCredentials())
            return Uri_helper::redirect('management');
        //get_class($this)
    }

}