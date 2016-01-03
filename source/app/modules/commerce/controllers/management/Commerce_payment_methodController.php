<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Payment Method
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_payment_methodController
 **/
class Commerce_payment_methodController extends Brightery_Controller
{
   protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_payment_method");
    }

    public function indexAction($offset = 0)
    {
        $this->permission('index');
        $this->load->library('pagination');
        $commerce_payment_method = new \modules\commerce\models\Commerce_payment_method();
        
        $commerce_payment_method->_select = "commerce_payment_method_id, name, fees, image, settings";
        $commerce_payment_method->_limit = $this->config->get('limit');
        $commerce_payment_method->_offset = $offset;

        return $this->render('commerce_payment_method/index', [
            'items' => $commerce_payment_method->get(),
            'pagination' => $this->Pagination->generate([
                'url' => Uri_helper::url('management/commerce_payment_method/index'),
                'total' => $commerce_payment_method->get(true),
                'limit' => $commerce_payment_method->_limit,
                'offset' => $commerce_payment_method->_offset
                ]
            )
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        if($id)
            $commerce_payment_method = new \modules\commerce\models\Commerce_payment_method('edit');
        else 
            $commerce_payment_method = new \modules\commerce\models\Commerce_payment_method('add');

        $commerce_payment_method->attributes = $this->Input->post();
        if ($id)
            $commerce_payment_method->commerce_payment_method_id = $id;
        
        if ($commerce_payment_method->save())
            Uri_helper::redirect("management/commerce_payment_method");
        else
            return $this->render('commerce_payment_method/manage', [
                'item' => $id ? $commerce_payment_method->get() : null
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce_payment_method = new \modules\commerce\models\Commerce_payment_method();
        $commerce_payment_method->commerce_payment_method_id = $id;
        if ($commerce_payment_method->delete())
            Uri_helper::redirect("management/commerce_payment_method");
    }
}