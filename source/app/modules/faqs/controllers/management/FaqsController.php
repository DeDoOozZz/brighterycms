<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Faqs
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module faqs
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/faqs
 * @controller FaqsController
 *
 * */
class FaqsController extends Brightery_Controller
{
    protected $layout = 'default';

    public function __construct()
    {
        parent::__construct();
        $this->language->load("faqs");
    }

    public function indexAction($offset = 0)
    {
        $this->permission('index');
        $this->load->library('pagination');
        $model = new \modules\faqs\models\Faqs();
        $model->where('language_id', $this->language->getDefaultLanguage());
        $model->_select = "faq_id, question, answer, visibility_status_id";
        $model->_limit = $this->config->get('limit');
        $model->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/faqs/index'),
            'total' => $model->get(true),
            'limit' => $model->_limit,
            'offset' => $model->_offset
        ];

        return $this->render('faqs/index', [
            'items' => $model->get(),
            'pagination' => $this->Pagination->generate($config)
        ]);
    }

    public function manageAction($id = false)
    {
        $this->permission('manage');
        $model = new \modules\faqs\models\Faqs();
        $model->attributes = $this->Input->input['post'];
        $visibility = Form_helper::queryToDropdown('visibility_status', 'visibility_status_id', 'name');
        if ($id)
            $model->faq_id = $id;
        $model->language_id = $this->language->getDefaultLanguage();
        if (!$id)
            $model->created = date("Y-m-d H:i:s");

        if ($model->save())
            Uri_helper::redirect("management/faqs");
        else
            return $this->render('faqs/manage', [
                'item' => $id ? $model->get() : null,
                'visibility' => $visibility
            ]);
    }

    public function deleteAction($id = false)
    {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\faqs\models\Faqs();
        $model->faq_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/faqs");
    }

}
