<?php defined('ROOT') OR exit('No direct script access allowed');

class Crud extends Brightery_Controller
{
    protected $layout = 'default';
    protected $_data = [];
    protected $model_instance;
    protected $_view_folder;
    protected $_set= [];

    public function __construct()
    {
        parent::__construct();
        $this->_view_folder = strtolower(str_replace('Controller', '', $this->_controller));
        $this->language->load($this->_module);
        $model_instance = '\\modules\\' . $this->_module . '\\models\\' . $this->_model;
        if (class_exists($model_instance))
            $this->model_instance = new $model_instance();
    }

    public function indexAction($offset = 0)
    {
        $this->permission('index');
        $this->load->library('pagination');

        $this->model_instance->language_id = $this->language->getDefaultLanguage();
        $this->model_instance->_limit = $this->config->get('limit');
        $this->model_instance->_offset = $offset;
        $config = [
            'url' => Uri_helper::url('management/' . $this->_module . '/index'),
            'total' => $this->model_instance->get(true),
            'limit' => $this->model_instance->_limit,
            'offset' => $this->model_instance->_offset
        ];
        return $this->render($this->_view_folder . '/index', [
            'controller' => $this->_controller,
            'items' => $this->model_instance->get(),
            'pagination' => $this->Pagination->generate($config)
        ]);
    }


    public function manageAction($id = false)
    {
        $this->permission('manage');

        if( ! $this->_set && $_POST)
            $this->_set = $this->Input->post();
            $this->model_instance->set($this->_set);

        if ($id)
            $this->model_instance->{$this->model_instance->getPrimaryKey()} = $id;

        $this->model_instance->language_id = $this->language->getDefaultLanguage();

        if (!$id)
            $this->model_instance->created = date("Y-m-d H:i:s");

        if ($this->model_instance->save())
            Uri_helper::redirect("management/" . $this->_controller);
        else
            return $this->render($this->_view_folder . '/manage', [
                'item' => $id ? $this->model_instance->get() : null,
                'data' => $this->_data
            ]);
    }

    public function deleteAction($id = false)
    {
        $this->permission('delete');

        if (!$id)
            return Brightery::error404();

        $this->model_instance->{$this->model_instance->getPrimaryKey()} = $id;

        if (!$this->model_instance->get())
            return Brightery::error404();

        if ($this->model_instance->delete())
            Uri_helper::redirect("management/" . $this->_controller);
    }


}