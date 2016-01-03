<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Resumes
 *
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * @interface frontend
 * @module resumes
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/resumes
 * @controller ResumesController
 *
 * */
class ResumesController extends Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
       $this->language->load('resumes');
    }

    public function indexAction() {
//        $this->permission('index');
//        if (!$Resumes)
//            Brightery::error404();
        $Resumes = new \modules\resumes\models\Resume_activities();
        $Resumes->language_id = $this->language->getDefaultLanguage();
        $Resumes->user_id = 1;
        $date_of_birth = $Resumes->date_of_birth;
//        $nationality_id = $Resumes->nationality_id;
//        $marital_status_id = $Resumes->marital_status_id;
        $date_of_birth = $Resumes->date_of_birth;
//        $Resumes->nationality_id = $nationality_id;
//        $Resumes->marital_status_id = $marital_status_id ;
        var_dump($Resumes);
        $res = $Resumes->get();
//        if (!$res)
//            Brightery::error404();
        return $this->render('resumes', [
                    'item' => $res
        ]);
    }

}
