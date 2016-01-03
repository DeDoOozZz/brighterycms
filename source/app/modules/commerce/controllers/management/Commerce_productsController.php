<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Commerce Products
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module commerce
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/commerce
 * @controller Commerce_productsController
 *
 **/
class Commerce_productsController extends Brightery_Controller
{
    protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("commerce_products");
    }

    public function indexAction($offset = 0)
    {
        $this->permission('index');

        $commerce = new \modules\commerce\models\Commerce_products();
        $commerce->_order_by['name'] = 'ASC';
        $commerce->_joins = [
            'commerce_categories' => ['`commerce_categories`.`commerce_category_id`=`commerce_products`.`commerce_category_id`', 'INNER'],
        ];
        $this->load->library('pagination');
        $commerce->_limit = $this->config->get('limit');
        $commerce->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/commerce_products/index'),
            'total' => $commerce->get(true),
            'limit' => $commerce->_limit,
            'offset' => $commerce->_offset
        ];
        return $this->render('commerce_products/index', [
            'items' => $commerce->get(),
            'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false)
    {
        $this->permission('manage');
        $commerce = new \modules\commerce\models\Commerce_products();
        $product_images = new \modules\commerce\models\Commerce_product_images(false);

        $commerce->set('name', $this->input->post('name'));
        $commerce->set('commerce_category_id', $this->input->post('commerce_category_id'));
        $commerce->set('price', $this->input->post('price'));
        $commerce->set('type', $this->input->post('type'));
        $commerce->set('discount', $this->input->post('discount'));
        $commerce->set('commerce_brand_id', $this->input->post('commerce_brand_id'));
        $categories = [];
        $cats = Form_helper::queryToDropdown('commerce_categories', 'commerce_category_id', 'title', FALSE, 'WHERE parent="0"');
        foreach ($cats as $catk => $catv) {
            $categories[$catk] = $catv;
            foreach(Form_helper::queryToDropdown('commerce_categories', 'commerce_category_id', 'title', FALSE, 'WHERE parent="' . $catk . '"') as $subk => $subv)
                $categories[$subk] = ' |-- '. $subv;
        }
        $categories = Form_helper::arrayToDropdown($categories);
        $brands = Form_helper::queryToDropdown('commerce_brands', 'commerce_brand_id', 'name');
        if ($id)
            $commerce->commerce_product_id = $id;
        $commerce->language_id = $this->language->getDefaultLanguage();


        if ($id = $commerce->save()) {
            $product_images->commerce_product_id = $id;
            $product_images->delete();
            foreach ($this->input->post('uploaded_files') as $file) {
                $product_images->commerce_product_id = $id;
                $product_images->product_image = $file;
                $product_images->save();
            }
            Uri_helper::redirect("management/commerce_products");
        } else
            return $this->render('commerce_products/manage', [
                'item' => $id ? $commerce->get() : null,
                'categories' => $categories,
                'brands' => $brands,
                'type' => ['normal' => 'Normal', 'weighted' => 'Weighted', 'digital' => 'Digital'],
            ]);
    }

    public function deleteAction($id = false)
    {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $commerce = new \modules\commerce\models\Commerce_products();
        $commerce->commerce_product_id = $id;
        if ($commerce->delete())
            Uri_helper::redirect("management/commerce_products");
    }

    public function product_imagesAction($id = null)
    {
        $this->permission('index');
        if (!$id)
            return Brightery::error404();

        $product_images = $this->Database->query("SELECT commerce_product_images.*, `commerce_products`.`commerce_product_id`"
            . "FROM `commerce_product_images` "
            . "LEFT JOIN `commerce_products` ON `commerce_products`.`commerce_product_id`=`commerce_product_images`.`commerce_product_id`"
            . "WHERE `commerce_products`.`commerce_product_id`='$id'"
            . "")->result();

        return $this->render('commerce_products/product_images', [
            'items' => $product_images,
            'id' => $id
        ]);
    }

    public function manage_filesAction($id = false)
    {
        $this->layout = 'ajax';
        if ($id) {
            $model = new \modules\commerce\models\Commerce_product_images();

        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!$id)
                return false;
            $model->commerce_product_id = $id;
            foreach ($model->get() as $file) {
                $filename = $file->product_image;
                $file_id = $file->commerce_product_image_id;
                $files[] = [
                    'name' => $filename,
                    'size' => filesize('./cdn/' . $this->_module . '/' . $filename),
                    'url' => Uri_helper::cdn($this->_module . '/' . $filename),
                    'primary' => $file->primary,
                    'thumbnailUrl' => Uri_helper::cdn($this->_module . '/' . $filename),
                    'deleteUrl' => Uri_helper::url('management/commerce_products/manage_files/' . $file_id) . '?file=' . $filename,
                    'deleteType' => 'DELETE'
                ];
            }
            return json_encode(['files' => $files]);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($this->uploadFiles($_FILES) as $file) {
                $files[] = [
                    'name' => $file['file_name'],
                    'size' => $file['file_size'],
                    'url' => Uri_helper::cdn($this->_module . '/' . $file['file_name']),
                    'primary' => '',
                    'thumbnailUrl' => Uri_helper::cdn($this->_module . '/' . $file['file_name']),
                    'deleteUrl' => Uri_helper::url('management/commerce_products/manage_files/') . '?file=' . $file['file_name'],
                    'deleteType' => 'DELETE'
                ];
            }
            return json_encode(['files' => $files]);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($id) {
                $model->commerce_product_image_id = $id;
                $model->delete();
                echo '{"' . $this->input->get('file') . '":true}';
            } else
                echo '{"' . $this->input->get('file') . '":true}';
        }
    }

    private function uploadFiles($files)
    {
        $input_name = 'files';
        $config = array(
            'upload_path' => './cdn/' . $this->_module,
            'allowed_types' => '*',
        );
        $__files = array();
        for ($i = 0; $i < count($files[$input_name]['name']); $i++) {
            $_FILES[$input_name]['name'] = $files[$input_name]['name'][$i];
            $_FILES[$input_name]['type'] = $files[$input_name]['type'][$i];
            $_FILES[$input_name]['tmp_name'] = $files[$input_name]['tmp_name'][$i];
            $_FILES[$input_name]['error'] = $files[$input_name]['error'][$i];
            $_FILES[$input_name]['size'] = $files[$input_name]['size'][$i];
            $this->upload->initialize($config);

            if ($this->upload->do_upload($input_name)) {
                $data = $this->upload->data();
                $__files[] = $data;
            } else {
                return 'ERROR';
            }
        }
        return $__files;
    }
}
