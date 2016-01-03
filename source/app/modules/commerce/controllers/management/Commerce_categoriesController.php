<?php defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Categories Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_categoriesController
 *
 **/

class Commerce_categoriesController extends Brightery_Controller
{

    protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_categories");
    }

    public function indexAction($offset = 0)
    {
        $this->permission('index');

        $commerce = new \modules\commerce\models\Commerce_categories();
        $commerce->parent = 0;
        $commerce->_select = "commerce_category_id, parent, title, seo, image, featured, description";
        $this->load->library('pagination');
        $commerce->_limit = $this->config->get('limit');
        $commerce->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/commerce_categories/index'),
            'total' => $commerce->get(true),
            'limit' => $commerce->_limit,
            'offset' => $commerce->_offset
        ];
        return $this->render('commerce_categories/index', [
            'items' => $commerce->get(),
            'pagination' => $this->Pagination->generate($config),
            'category_model' => $commerce
        ]);
    }

    public function manageAction($id = false)
    {
        $this->permission('manage');

        if ($id) {
            $commerce = new \modules\commerce\models\Commerce_categories('edit');
            $commerce->commerce_category_id = $id;
        }
        else
            $commerce = new \modules\commerce\models\Commerce_categories('add');
        $commerce->set('title', $this->input->post('title'));
        $commerce->set('seo', $this->input->post('seo'));
        $commerce->set('parent', $this->input->post('parent'));
        $commerce->set('description', $this->input->post('description'));
        $commerce->set('featured', $this->input->post('featured'));

        $commerce->language_id = $this->language->getDefaultLanguage();

        $cat['0'] = $this->Language->phrase('main_category');
        $cats = Form_helper::queryToDropdown('commerce_categories', 'commerce_category_id', 'title', $cat, 'WHERE parent = "0"');

        if ($commerce->save())
        {
            Uri_helper::redirect("management/commerce_categories");
        }
        else
            return $this->render('commerce_categories/manage', [
                'item' => $id ? $commerce->get() : null,
                'categories' => $cats,
                'menu' => ['yes' => 'Yes', 'no' => 'No']
            ]);
    }

    public function deleteAction($id = false)
    {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce = new \modules\commerce\models\Commerce_categories();
        $commerce->commerce_category_id = $id;
        if ($commerce->delete())
            Uri_helper::redirect("management/commerce_categories");
    }

}
