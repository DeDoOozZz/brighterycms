<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Classfied Post Job 
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module classfied
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/classfied
 * @controller Classfied_post_jobController
 *
 * */
class Classfied_post_jobController extends Brightery_Controller {

    protected $layout = 'classfied';

    public function __construct() {
        parent::__construct();
        $this->language->load("classfied_jobs");
    }

    public function indexAction() {

        $model = new \modules\classfied\models\Classfied_jobs();

        $model->set('classfied_type_id', $this->input->post('classfied_type_id'));
        $model->set('classfied_category_id', $this->input->post('classfied_category_id'));
        $model->set('title', $this->input->post('title'));
        $model->set('description', $this->input->post('description'));
        $model->set('company', ($this->input->post('company')));
        $model->set('classfied_city_id', ($this->input->post('classfied_city_id')));
        $model->set('classfied_area_id', $this->input->post('classfied_area_id'));
        $model->set('classfied_country_id', $this->input->post('classfied_country_id'));
        $model->set('url', ($this->input->post('url')));
        $model->set('poster_email', ($this->input->post('poster_email')));
        $model->set('salary_from', ($this->input->post('salary_from')));
        $model->set('salary_to', ($this->input->post('salary_to')));
        $model->set('classfied_currency_id', ($this->input->post('classfied_currency_id')));
        $model->set('is_hidden_num', $this->input->post('is_hidden_num') ? 1 : 0);
        $model->set('phone_num', ($this->input->post('phone_num')));
        $model->set('classfied_experience_id', ($this->input->post('classfied_experience_id')));
        $model->set('candidate_location', $this->input->post('candidate_location'));


        $categories = Form_helper::queryToDropdown('classfied_categories', 'classfied_category_id', 'name');
        $types = Form_helper::queryToDropdown('classfied_types', 'classfied_type_id', 'name');
//        $cities = Form_helper::queryToDropdown('classfied_cities', 'classfied_city_id', 'name');
        $cities = ['' => $this->language->phrase('select_city')];
        $experiences = Form_helper::queryToDropdown('classfied_experience', 'classfied_experience_id', 'name');
        $currenies = Form_helper::queryToDropdown('classfied_currencies', 'classfied_currency_id', 'name', ['' => $this->language->phrase('select_currency')]);
//        $areas = Form_helper::queryToDropdown('classfied_areas', 'classfied_area_id', 'name');
        $areas = ['' => $this->language->phrase('select_area')];
        $countries = Form_helper::queryToDropdown('classfied_countries', 'classfied_country_id', 'name', ['' => $this->language->phrase('select_country')]);
      
        if ($model->validate()) {
            if ($this->input->post('confirm') == 1) {
                $model->set('classfied_type_id', $this->input->post('classfied_type_id'));
                $model->set('classfied_category_id', $this->input->post('classfied_category_id'));
                $model->set('title', $this->input->post('title'));
                $model->set('description', $this->input->post('description'));
                $model->set('company', $this->input->post('company'));
                $model->set('classfied_city_id', $this->input->post('classfied_city_id'));
                $model->set('classfied_country_id', $this->input->post('classfied_country_id'));
                $model->set('classfied_area_id', $this->input->post('classfied_area_id'));
                $model->set('url', $this->input->post('url'));
                $model->set('poster_email', $this->input->post('poster_email'));
                $model->set('salary_from', $this->input->post('salary_from'));
                $model->set('salary_to', $this->input->post('salary_to'));
                $model->set('classfied_currency_id', $this->input->post('classfied_currency_id'));
                $model->set('is_hidden_num', $this->input->post('is_hidden_num'));
                $model->set('phone_num', $this->input->post('phone_num'));
                $model->set('classfied_experience_id', $this->input->post('classfied_experience_id'));
                $model->set('candidate_location', $this->input->post('candidate_location'));
                $model->set('created_on', date("Y-m-d"));
                if ($model->save()) {
                    return $this->render('classfied_thankyou');
                } else {
                    return Brightery::error404();
                }
            }

            $categories = $categories[$this->input->post('classfied_category_id')];
            $types = $types[$this->input->post('classfied_type_id')];
            $experiences = $experiences[$this->input->post('classfied_experience_id')];
            $currenies = $currenies[$this->input->post('classfied_currency_id')];
            $cities = Form_helper::queryToDropdown('classfied_cities', 'classfied_city_id', 'name', null, 'WHERE classfied_city_id= "' . $this->input->post('classfied_city_id') . '"')[$this->input->post('classfied_city_id')];
            $areas = Form_helper::queryToDropdown('classfied_areas', 'classfied_area_id', 'name', null, 'WHERE classfied_area_id= "' . $this->input->post('classfied_area_id') . '"')[$this->input->post('classfied_area_id')];
            $countries = $countries[$this->input->post('classfied_country_id')];
//            $candidate = Form_helper::queryToDropdown('countries', 'classfied_country_id', 'name', null, 'WHERE classfied_country_id= "' . $this->input->post('condidate_location') . '"')[$this->input->post('condidate_location')];
            return $this->render('classfied_review_job', [
                        'categories' => $categories,
                        'cities' => $cities,
                        'types' => $types,
                        'experiences' => $experiences,
                        'currenies' => $currenies,
                        'areas' => $areas,
                        'countries' => $countries,
//                        'candidate' => $candidate
            ]);
        } else
            return $this->render('classfied_post_job', [
                        'categories' => $categories,
                        'cities' => $cities,
                        'types' => $types,
                        'experiences' => $experiences,
                        'currenies' => $currenies,
                        'areas' => $areas,
                        'countries' => $countries
            ]);
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
