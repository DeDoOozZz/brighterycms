<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Job 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_jobController
 *
 * */
class Classfied_jobController extends Brightery_Controller {

    protected $layout = 'classfied';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_jobs");
    }

    public function indexAction($id) {




        $info = $this->Database->query("SELECT classfied_jobs.*,`classfied_countries`.`name` as country,`classfied_cities`.`name` as city, `classfied_areas`.`name` as area, `classfied_categories`.`name` as category, `classfied_types`.`name` as type, `classfied_experience`.`name` as experience, `classfied_currencies`.`name` as currency, locations.name as location "
                        . "FROM `classfied_jobs` "
                        . "LEFT JOIN `classfied_countries` ON `classfied_countries`.`classfied_country_id`=`classfied_jobs`.`classfied_country_id`"
                        . "LEFT JOIN `classfied_countries` locations ON `locations`.`classfied_country_id`=`classfied_jobs`.`candidate_location`"
                        . "LEFT JOIN `classfied_cities` ON `classfied_cities`.`classfied_city_id`=`classfied_jobs`.`classfied_city_id`"
                        . "LEFT JOIN `classfied_areas` ON `classfied_areas`.`classfied_area_id`=`classfied_jobs`.`classfied_area_id`"
                        . "LEFT JOIN `classfied_categories` ON `classfied_categories`.`classfied_category_id`=`classfied_jobs`.`classfied_category_id`"
                        . "LEFT JOIN `classfied_types` ON `classfied_types`.`classfied_type_id`=`classfied_jobs`.`classfied_type_id`"
                        . "LEFT JOIN `classfied_experience` ON `classfied_experience`.`classfied_experience_id`=`classfied_jobs`.`classfied_experience_id`"
                        . "LEFT JOIN `classfied_currencies` ON `classfied_currencies`.`classfied_currency_id`=`classfied_jobs`.`classfied_currency_id`"
                        . "WHERE classfied_jobs.classfied_job_id='$id'")->row();


        return $this->render('classfied_job', [
                    'item' => $info
        ]);


        if($_POST)
            mail('', 'New Applicant', '');

    }



}
