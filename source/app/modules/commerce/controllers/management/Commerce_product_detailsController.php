<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Product Details
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_product_detailsController
 **/
class Commerce_product_detailsController extends Brightery_Controller
{
    protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_product_details");
    }

    public function indexAction($offset = 0)
    {
        $this->permission('index');
        $this->load->library('pagination');
        $commerce_product_details = new \modules\commerce\models\Commerce_product_details();
        
        $commerce_product_details->_select = "commerce_product_detail_id, name, commerce_product_id";
        $commerce_product_details->_limit = $this->config->get('limit');
        $commerce_product_details->_offset = $offset;

        return $this->render('commerce_product_details/index', [
            'items' => $commerce_product_details->get(),
            'pagination' => $this->Pagination->generate([
                'url' => Uri_helper::url('management/commerce_product_details/index'),
                'total' => $commerce_product_details->get(true),
                'limit' => $commerce_product_details->_limit,
                'offset' => $commerce_product_details->_offset
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
        $commerce_product_details = new \modules\commerce\models\Commerce_product_details();
        if($_POST)
            $commerce_product_details->attributes = ['name' => $this->input->post('name'),'commerce_product_id' => $this->input->post('commerce_product_id'),];;
        if ($id)
            $commerce_product_details->commerce_product_detail_id = $id;
        

        //$users = Form_helper::queryToDropdown('users', 'user_id', 'title', null, 'WHERE status != "active"');

        if ($commerce_product_details->save())
            Uri_helper::redirect("management/commerce_product_details");
        else
            return $this->render('commerce_product_details/manage', [
                'item' => $id ? $commerce_product_details->get() : null
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce_product_details = new \modules\commerce\models\Commerce_product_details();
        $commerce_product_details->commerce_product_detail_id = $id;
        if ($commerce_product_details->delete())
            Uri_helper::redirect("management/commerce_product_details");
    }
}