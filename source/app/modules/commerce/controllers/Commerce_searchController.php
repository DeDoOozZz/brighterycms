<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Search
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_searchController
 * */
class Commerce_searchController extends Brightery_Controller
{

    protected $layout = 'commerce';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_search");
    }

    public function indexAction($offset = 0)
    {
        $category = new \modules\commerce\models\Commerce_categories();
        $brands = new \modules\commerce\models\Commerce_brands();
        $product = new \modules\commerce\models\Commerce_products();
        $category->_select = "commerce_category_id, title, parent";
        $category->parent = 0;
        $sorting = [
            '' => 'Sort By',
            'name' => 'Name',
            'low_price' => 'Low Price',
            'heigh_price' => 'Heigh Price'
        ];

        if (is_array($this->input->get('category_id')) && count($this->input->get('category_id')) && !empty($this->input->get('category_id.0')))
            $product->where('commerce_category_id IN (SELECT commerce_category_id FROM commerce_categories WHERE parent IN ("' . implode('","', $this->input->get('category_id')) . '")) '); //UNION ALL SELECT ("'. implode('","', $this->input->get('category_id')) .'

        if ($this->input->get('brand_id'))
            $product->where('commerce_brand_id IN ("' . implode('","', $this->input->get('brand_id')) . '")');

        if ($this->input->get('q'))
            $product->like('commerce_products.name', $this->input->get('q'));

        if ($this->input->get('from_price'))
            $product->like('commerce_products.price >=', $this->input->get('from_price'));

        if ($this->input->get('to_price'))
            $product->like('commerce_products.price <=', $this->input->get('to_price'));

        if ($this->input->get('sorting'))
            if ($this->input->get('sorting') == 'name')
                $product->_order_by['name'] = 'ASC';
            elseif ($this->input->get('sorting') == 'low_price')
                $product->_order_by['price'] = 'ASC';
            elseif ($this->input->get('sorting') == 'heigh_price')
                $product->_order_by['price'] = 'DESC';

        $this->load->library('pagination');
        $product->_limit = $this->config->get('limit');
        $product->_offset = $offset;

        return $this->render('commerce_search', [
            'categories' => $category->get(),
            'brands' => $brands->get(),
            'sorting' => $sorting,
            'products' => $product->get(),
            'product_model' => $product,
            'pagination' => $this->Pagination->generate([
                'url' => Uri_helper::url('commerce_search/index'),
                'total' => $product->get(true),
                'limit' => $product->_limit,
                'offset' => $product->_offset
            ])
        ]);
    }

    public function autocomepleteAction() {
        $res = [];
        if($this->input->get('term')){
            $result = $this->Database->query("SELECT name from commerce_products WHERE name LIKE '%".$this->input->get('term')."%'")->result();
            foreach($result as $r)
            $res[] = [
                'id' => $r->name,
                'lable' =>$r->name,
                'value' =>$r->name,
            ];
        }
        echo json_encode($res);
    }
}
