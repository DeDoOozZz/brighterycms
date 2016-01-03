<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Product Detail Options
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_product_detail_optionsController
 **/
class Commerce_product_detail_optionsController extends Brightery_Controller
{
    protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_product_detail_options");
    }

    public function indexAction($offset = 0)
    {
        $this->permission('index');
        $this->load->library('pagination');
        $commerce_product_detail_options = new \modules\commerce\models\Commerce_product_detail_options();
        
        $commerce_product_detail_options->_select = "commerce_product_detail_option_id, commerce_product_detail_id, name, price";
        $commerce_product_detail_options->_limit = $this->config->get('limit');
        $commerce_product_detail_options->_offset = $offset;

        return $this->render('commerce_product_detail_options/index', [
            'items' => $commerce_product_detail_options->get(),
            'pagination' => $this->Pagination->generate([
                'url' => Uri_helper::url('management/commerce_product_detail_options/index'),
                'total' => $commerce_product_detail_options->get(true),
                'limit' => $commerce_product_detail_options->_limit,
                'offset' => $commerce_product_detail_options->_offset
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
        $commerce_product_detail_options = new \modules\commerce\models\Commerce_product_detail_options();
        if($_POST)
            $commerce_product_detail_options->attributes = ['commerce_product_detail_id' => $this->input->post('commerce_product_detail_id'),'name' => $this->input->post('name'),'price' => $this->input->post('price'),];;
        if ($id)
            $commerce_product_detail_options->commerce_product_detail_option_id = $id;
        

        //$users = Form_helper::queryToDropdown('users', 'user_id', 'title', null, 'WHERE status != "active"');

        if ($commerce_product_detail_options->save())
            Uri_helper::redirect("management/commerce_product_detail_options");
        else
            return $this->render('commerce_product_detail_options/manage', [
                'item' => $id ? $commerce_product_detail_options->get() : null
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce_product_detail_options = new \modules\commerce\models\Commerce_product_detail_options();
        $commerce_product_detail_options->commerce_product_detail_option_id = $id;
        if ($commerce_product_detail_options->delete())
            Uri_helper::redirect("management/commerce_product_detail_options");
    }
}