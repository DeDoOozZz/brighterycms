<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Jobs Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_jobsController
 *
 * */
class Classfied_jobsController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_jobs");
    }

    public function indexAction($offset = 0) {
        $this->permission('index');

        $classfied = new \modules\classfied\models\Classfied_jobs();
        $classfied->_select = "`classfied_jobs`.classfied_job_id, `classfied_jobs`.created_on, `classfied_jobs`.title,`classfied_categories`.`name` as category,`classfied_types`.`name` as type, `classfied_jobs`.`is_active`";
        $classfied->_joins = [
            'classfied_categories' => ['`classfied_categories`.`classfied_category_id`=`classfied_jobs`.`classfied_category_id`', 'INNER'],
            'classfied_types' => ['`classfied_types`.`classfied_type_id`=`classfied_jobs`.`classfied_type_id`', 'INNER']
        ];
        $this->load->library('pagination');
        $classfied->_limit = $this->config->get('limit');
        $classfied->_offset = $offset;
        $classfied->_order_by['classfied_jobs.classfied_job_id']= 'DESC';
        $config = [
            'url' => Uri_helper::url('management/classfied_jobs/index'),
            'total' => $classfied->get(true),
            'limit' => $classfied->_limit,
            'offset' => $classfied->_offset
        ];
        return $this->render('classfied_jobs/index', [
                    'items' => $classfied->get(),
                    'pagination' => $this->Pagination->generate($config),
                    'category_model' => $classfied
        ]);
    }

    public function manageAction($id = false) {
        $this->permission('manage');
        $classfied = new \modules\classfied\models\Classfied_jobs();

        $classfied->set('classfied_type_id', $this->input->post('classfied_type_id'));
        $classfied->set('classfied_category_id', $this->input->post('classfied_category_id'));
        $classfied->set('title', $this->input->post('title'));
        $classfied->set('description', $this->input->post('description'));
        $classfied->set('company', $this->input->post('company'));
        $classfied->set('classfied_city_id', $this->input->post('classfied_city_id'));
        $classfied->set('classfied_area_id', $this->input->post('classfied_area_id'));
        $classfied->set('classfied_country_id', $this->input->post('classfied_country_id'));
        $classfied->set('url', $this->input->post('url'));
        $classfied->set('created_on', $this->input->post('created_on'));
        $classfied->set('poster_email', $this->input->post('poster_email'));
        $classfied->set('workplace', $this->input->post('workplace'));
        $classfied->set('salary_from', $this->input->post('salary_from'));
        $classfied->set('salary_to', $this->input->post('salary_to'));
        $classfied->set('classfied_currency_id', ($this->input->post('classfied_currency_id')));
        $classfied->set('is_hidden_num', $this->input->post('is_hidden_num') ? 1 : 0);
        $classfied->set('phone_num', $this->input->post('phone_num'));
        $classfied->set('classfied_experience_id', $this->input->post('classfied_experience_id'));
        $classfied->set('candidate_location', $this->input->post('candidate_location'));

        $categories = Form_helper::queryToDropdown('classfied_categories', 'classfied_category_id', 'name');
        $types = Form_helper::queryToDropdown('classfied_types', 'classfied_type_id', 'name');
//        $cities = Form_helper::queryToDropdown('classfied_cities', 'classfied_city_id', 'name');
        $cities = ['' => $this->language->phrase('select_city')];
        $experiences = Form_helper::queryToDropdown('classfied_experience', 'classfied_experience_id', 'name');
        $currenies = Form_helper::queryToDropdown('classfied_currencies', 'classfied_currency_id', 'name', ['' => $this->language->phrase('select_currency')]);
//        $areas = Form_helper::queryToDropdown('classfied_areas', 'classfied_area_id', 'name');
        $areas = ['' => $this->language->phrase('select_area')];
        $countries = Form_helper::queryToDropdown('classfied_countries', 'classfied_country_id', 'name', ['' => $this->language->phrase('select_country')]);

        if ($id)
            $classfied->classfied_job_id = $id;
        
        if (!$id) {
            if ($_POST) {
                $classfied->created_on = date("Y-m-d");
            }
        }
        if ($classfied->save()) {

            Uri_helper::redirect("management/classfied_jobs");
        } else
            return $this->render('classfied_jobs/manage', [
                        'item' => $id ? $classfied->get() : null,
                        'categories' => $categories,
                        'cities' => $cities,
                        'types' => $types,
                        'experiences' => $experiences,
                        'currenies' => $currenies,
                        'areas' => $areas,
                        'countries' => $countries
            ]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');

        if (!$id) {
            return Brightery::error404();
        }
        $classfied = new \modules\classfied\models\Classfied_jobs();
        $classfied->classfied_job_id = $id;
        if ($classfied->delete())
            Uri_helper::redirect("management/classfied_jobs");
    }
    
    public function approveAction($id = false) {

        if (!$id) {
            return Brightery::error404();
        }
        echo 'iuui';
        $classfied = new \modules\classfied\models\Classfied_jobs(null);
        $classfied->where('classfied_job_id', $id);
        $classfied->set('is_active', '1');
        if ($classfied->save())
            Uri_helper::redirect("management/classfied_jobs");
    }

    public function get_citiesAction($country_id = null) {
        $this->layout = 'ajax';
        $city_id = $this->input->post('classfied_country_id');
        $cities = Form_helper::queryToDropdown('classfied_cities', 'classfied_city_id', 'name', ['' => $this->language->phrase('select_city')], 'WHERE classfied_country_id= "' . $country_id . '"');
        foreach ($cities as $cityk => $cityv) {
            if ($cityk == $city_id)
                echo '<option value="' . $cityk . '" selected="selected">' . $cityv . '</option>';
            else
                echo '<option value="' . $cityk . '">' . $cityv . '</option>';
        }
    }

    public function get_areasAction($city_id = null) {
        $this->layout = 'ajax';
        $area_id = $this->input->post('classfied_area_id');
        $areas = Form_helper::queryToDropdown('classfied_areas', 'classfied_area_id', 'name', ['' => $this->language->phrase('select_area')], 'WHERE classfied_city_id= "' . $city_id . '"');
        foreach ($areas as $areak => $areav) {
            if ($areak == $area_id)
                echo '<option value="' . $areak . '" selected="selected">' . $areav . '</option>';
            else
                echo '<option value="' . $areak . '">' . $areav . '</option>';
        }
    }

}
