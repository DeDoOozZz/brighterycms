<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Home 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_homeController
 *
 * */
class Classfied_homeController extends Brightery_Controller {

    protected $layout = 'classfied';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_categories");
        $this->language->load("classfied_jobs");
    }

    public function indexAction() {
        $jobs = new \modules\classfied\models\Classfied_jobs();
        $jobs->is_active = 1;
        $jobs->_select = 'classfied_jobs.classfied_job_id, classfied_jobs.title, classfied_jobs.created_on, classfied_jobs.company, `classfied_countries`.`image` as country_image, `locations`.`image` as location_image, `locations`.`name` as location_name, `classfied_countries`.`name` as country_name,`classfied_types`.`name` as type, `classfied_types`.`color`, (SELECT COUNT(*) FROM classfied_job_applications WHERE classfied_job_applications.classfied_job_id = classfied_jobs.classfied_job_id) as appicants';
        $jobs->_joins = [
            'classfied_countries' => ['`classfied_countries`.`classfied_country_id`=`classfied_jobs`.`classfied_country_id`', 'left'],
            'classfied_countries` `locations' => ['`locations`.`classfied_country_id`=`classfied_jobs`.`classfied_country_id`', 'left'],
            'classfied_types' => ['`classfied_types`.`classfied_type_id`=`classfied_jobs`.`classfied_type_id`', 'left'],
        ];
        
        $jobs->_order_by['classfied_jobs.classfied_job_id'] = 'DESC';
        $jobs->_limit = 6;
        $jobs->spotlight = 1;
        $spotlighted = $jobs->get();

        $jobs->spotlight = null;
//        $jobs = new \modules\classfied\models\Classfied_jobs();
//        $jobs->is_active = 1;
//        $jobs->_select = 'classfied_jobs.title, classfied_jobs.created_on, classfied_jobs.company, `classfied_countries`.`image` as country_image, `locations`.`image` as location_image, `locations`.`name` as location_name, `classfied_countries`.`name` as country_name,`classfied_types`.`name` as type, `classfied_types`.`color`, (SELECT COUNT(*) FROM classfied_job_applications WHERE classfied_job_applications.classfied_job_id = classfied_jobs.classfied_job_id) as appicants';
//        $jobs->_joins = [
//            'classfied_countries' => ['`classfied_countries`.`classfied_country_id`=`classfied_jobs`.`classfied_country_id`', 'left'],
//            'classfied_countries` `locations' => ['`locations`.`classfied_country_id`=`classfied_jobs`.`classfied_country_id`', 'left'],
//            'classfied_types' => ['`classfied_types`.`classfied_type_id`=`classfied_jobs`.`classfied_type_id`', 'left'],
//        ];
//        
//        $jobs->_order_by['classfied_jobs.classfied_job_id'] = 'DESC';
//        $jobs->_limit = 6;
        $latest_added = $jobs->get();
        
        
//        $jobs = new \modules\classfied\models\Classfied_jobs();
//        $jobs->is_active = 1;
//        $jobs->_select = 'classfied_jobs.title, classfied_jobs.created_on, classfied_jobs.company, `classfied_countries`.`image` as country_image, `locations`.`image` as location_image, `locations`.`name` as location_name, `classfied_countries`.`name` as country_name,`classfied_types`.`name` as type, `classfied_types`.`color`, (SELECT COUNT(*) FROM classfied_job_applications WHERE classfied_job_applications.classfied_job_id = classfied_jobs.classfied_job_id) as appicants';
//        $jobs->_joins = [
//            'classfied_countries' => ['`classfied_countries`.`classfied_country_id`=`classfied_jobs`.`classfied_country_id`', 'left'],
//            'classfied_countries` `locations' => ['`locations`.`classfied_country_id`=`classfied_jobs`.`classfied_country_id`', 'left'],
//            'classfied_types' => ['`classfied_types`.`classfied_type_id`=`classfied_jobs`.`classfied_type_id`', 'left'],
//        ];
        
        $jobs->_order_by = null;
        $jobs->_order_by['(SELECT COUNT(*) FROM classfied_job_applications WHERE classfied_job_applications.classfied_job_id = classfied_jobs.classfied_job_id)'] = 'DESC';
//        $jobs->_limit = 6;
        $most_applied = $jobs->get();
        return $this->render('classfied_home', [
            'spotlighted' => $spotlighted,
            'latest_added' => $latest_added,
            'most_applied' => $most_applied
        ]);
    }

}
