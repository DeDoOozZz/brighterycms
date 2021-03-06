<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Category
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_categoryController
 *
 * */
class Classfied_categoryController extends Brightery_Controller {

    protected $layout = 'classfied';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_categories");
        $this->language->load("classfied_jobs");
    }

    public function indexAction($id, $offset = 0) {
        $category = new \modules\classfied\models\Classfied_categories();
        $jobs = new \modules\classfied\models\Classfied_jobs();
        $category->classfied_category_id = $id;
        $jobs->classfied_category_id = $id;
        $jobs->is_active = 1;
        $jobs->_select = 'classfied_jobs.classfied_job_id, classfied_jobs.title, classfied_jobs.created_on, classfied_jobs.company, `classfied_countries`.`image` as country_image, `locations`.`image` as location_image, `locations`.`name` as location_name, `classfied_countries`.`name` as country_name,`classfied_types`.`name` as type, `classfied_types`.`color`, (SELECT COUNT(*) FROM classfied_job_applications WHERE classfied_job_applications.classfied_job_id = classfied_jobs.classfied_job_id) as appicants';
        $jobs->_joins = [
            'classfied_countries' => ['`classfied_countries`.`classfied_country_id`=`classfied_jobs`.`classfied_country_id`', 'left'],
            'classfied_countries` `locations' => ['`locations`.`classfied_country_id`=`classfied_jobs`.`classfied_country_id`', 'left'],
            'classfied_types' => ['`classfied_types`.`classfied_type_id`=`classfied_jobs`.`classfied_type_id`', 'left'],
        ];

        $jobs->_order_by['classfied_jobs.classfied_job_id'] = 'DESC';
        $this->load->library('pagination');
        $jobs->_limit = $this->config->get('limit');
        $jobs->_offset = $offset;

        return $this->render('classfied_category', [
                    'item' => $category->get(),
                    'jobs' => $jobs->get(),
                    'pagination' => $this->Pagination->generate([
                        'url' => Uri_helper::url('classfied_category/index/' . $id),
                        'total' => $jobs->get(true),
                        'limit' => $jobs->_limit,
                        'offset' => $jobs->_offset
                    ])
        ]);
    }

}
