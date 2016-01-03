<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Product Attributes
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_product_attributesController
 **/
class Commerce_product_attributesController extends Brightery_Controller
{
   protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_product_attributes");
    }

    public function indexAction($offset = 0)
    {
        $this->permission('index');
        $this->load->library('pagination');
        $commerce_product_attributes = new \modules\commerce\models\Commerce_product_attributes();
        
        $commerce_product_attributes->_select = "commerce_product_attribute_id, commerce_category_attribute_id, value, commerce_product_id";
        $commerce_product_attributes->_limit = $this->config->get('limit');
        $commerce_product_attributes->_offset = $offset;

        return $this->render('commerce_product_attributes/index', [
            'items' => $commerce_product_attributes->get(),
            'pagination' => $this->Pagination->generate([
                'url' => Uri_helper::url('management/commerce_product_attributes/index'),
                'total' => $commerce_product_attributes->get(true),
                'limit' => $commerce_product_attributes->_limit,
                'offset' => $commerce_product_attributes->_offset
                ]
            )
        ]);
    }

    public function manageAction($id = false) {
        if($id) {
            $this->permission('edit');
        } else {
            $this->permission('add');
        }
        $commerce_product_attributes = new \modules\commerce\models\Commerce_product_attributes();
        if($_POST)
            $commerce_product_attributes->attributes = ['commerce_category_attribute_id' => $this->input->post('commerce_category_attribute_id'),'value' => $this->input->post('value'),'commerce_product_id' => $this->input->post('commerce_product_id'),];;
        if ($id)
            $commerce_product_attributes->commerce_product_attribute_id = $id;
        

        //$users = Form_helper::queryToDropdown('users', 'user_id', 'title', null, 'WHERE status != "active"');

        if ($commerce_product_attributes->save())
            Uri_helper::redirect("management/commerce_product_attributes");
        else
            return $this->render('commerce_product_attributes/manage', [
                'item' => $id ? $commerce_product_attributes->get() : null
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce_product_attributes = new \modules\commerce\models\Commerce_product_attributes();
        $commerce_product_attributes->commerce_product_attribute_id = $id;
        if ($commerce_product_attributes->delete())
            Uri_helper::redirect("management/commerce_product_attributes");
    }
}