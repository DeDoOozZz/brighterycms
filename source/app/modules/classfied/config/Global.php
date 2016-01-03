<?php


function classfied() {
    $cat_model = new \modules\classfied\models\Classfied_categories();
    $cat_model->_select = "classfied_categories.*, (SELECT COUNT(*) FROM classfied_jobs WHERE classfied_jobs.classfied_category_id = classfied_categories.classfied_category_id) AS total_vacancies ";
    $cat_model->_order_by['category_order'] = 'ASC';
    $country = new \modules\classfied\models\Classfied_countries();
    $country->_select = "classfied_countries.*, (SELECT COUNT(*) FROM classfied_jobs WHERE classfied_jobs.classfied_country_id = classfied_countries.classfied_country_id) AS total_vacancies ";


    return [
        'categories' => $cat_model->get(),
        'countries' => $country->get()
    ];
}