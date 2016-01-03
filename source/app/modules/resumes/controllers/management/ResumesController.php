<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Resumes
 *
 * @package Brightery CMS
 * @author Ahmed Magdy <a.magdymedany@gmail.com>
 * @version 1.0
 * @interface management
 * @module resumes
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/resumes
 * @controller ResumesController
 *
 * */
class ResumesController extends Brightery_Controller {

    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        $this->language->load('resumes');
    }

    public function indexAction() {
        $this->permission('index');
        print_r($this->input->post());
        $model = new \modules\resumes\models\Resumes();
        $model->select = "resume_id, language_id, user_id, date_of_birth, nationality_id, marital_status_id, created";
        return $this->render('resumes/index', [
                    'items' => $model->get()
        ]);
    }

    public function addAction($id = false) {
        $this->permission('add');
        if (!$id)
            return Brightery::error404();
        $modeel = new \modules\resumes\models\Resumes();
        $this->Database->set('user_id', $id);
        $modeel->user_id = $id;
        $this->Database->set('created', date("Y-m-d H:i:s"));
        $this->Database->set('language_id', $this->language->getDefaultLanguage());
//        $modeel->created = date("Y-m-d H:i:s");
        if ($this->Database->insert('resumes')) {
            $modeel->_select = 'resume_id';
            $resume = $modeel->get();
            $resume_id = $resume[0]->resume_id;
            Uri_helper::redirect("management/resumes/manage/$resume_id");
        }
    }

    public function manageAction($id = false) {
        $items = "";
        $locations = "";
        $work = "";
        $skill = "";
        $education = "";
        $activities = "";
        $languages = "";
        $hobbies = "";
        $personal = "";
        $this->permission('manage');
        ///////////////////////////Personal Informations/////////////////////////////////////
        $model_Personal = new \modules\resumes\models\Resumes();
        $model_Personal->_select = "resume_id, language_id, date_of_birth, nationality_id, marital_status_id, created";
        $model_Personal->resume_id = "$id";
        ///////////////////////////Matrial Status///////////////////////////////////////////
        $Martial = Form_helper::queryToDropdown('marital_status', 'marital_status_id', 'name');
        ///////////////////////////Nationalities////////////////////////////////////////////
        $Nationality = Form_helper::queryToDropdown('nationalities', 'nationality_id', 'name');
        ///////////////////////////Contacts/////////////////////////////////////
        $model_contact = new \modules\resumes\models\Resume_contacts();
        $model_contact->_select = "resume_contact_id, resume_id, language_id, contact_method, contact_detail, sort";
        $model_contact->resume_id = "$id";
        ///////////////////////////Locations////////////////////////////////////
        $model_locations = new \modules\resumes\models\Resume_locations();
        $model_locations->select = "resume_location_id, resume_id, language_id, location, lat, long, address, sort";
        $model_locations->resume_id = "$id";
        ///////////////////////////Work ////////////////////////////////
        $model_work = new \modules\resumes\models\Resume_work_history();
        $model_work->select = "resume_work_history_id , resume_id , language_id , company , from , to , category , title , nationality , responsbilities , sort";
        $model_work->resume_id = "$id";
        ///////////////////////////Skills ////////////////////////////////
        $model_skill = new \modules\resumes\models\Resume_skills();
        $model_skill->_select = "resume_skill_id , resume_id , language_id , category , content, sort";
        $model_skill->resume_id = "$id";
        ///////////////////////////Education ////////////////////////////////
        $model_education = new \modules\resumes\models\Resume_education();
        $model_education->_select = "resume_education_id , resume_id , language_id , degree  , field, school, from_year, from_month , to_year , to_month, sort";
        $model_education->resume_id = "$id";
        ///////////////////////////Activities ////////////////////////////////
        $model_activities = new \modules\resumes\models\Resume_activities();
        $model_activities->select = "resume_activity_id , resume_id , language_id , activity  , role , from , to , desc , sort";
        $model_activities->resume_id = "$id";
        ///////////////////////////Languages ////////////////////////////////
        $model_languages = new \modules\resumes\models\Resume_languages();
        $model_languages->_select = "resume_language_id , resume_id , language_id , name  , level , sort";
        $model_languages->resume_id = "$id";
        ///////////////////////////Hobbies ////////////////////////////////
        $model_hobbies = new \modules\resumes\models\Resume_hobbies();
        $model_hobbies->_select = "resume_hooby_id , resume_id , language_id , name, sort";
        $model_hobbies->resume_id = "$id";

        if ($id) {
            $model = new \modules\resumes\models\Resumes('edit');
            $items = $model->get();
            $contacts = $model_contact->get();
            $locations = $model_locations->get();
            $work = $model_work->get();
            $skill = $model_skill->get();
            $activities = $model_activities->get();
            $languages = $model_languages->get();
            $hobbies = $model_hobbies->get();
            $education = $model_education->get();
            $personal = $model_Personal->get();
//            $Martial = $model_Marital_status->get();
//            $Nationality = $model_Nationality->get();
        } else {
            $model = new \modules\resumes\models\Resumes('add');
            $contacts = [];
            $locations = [];
        }
        $model->attributes = $this->Input->post();
        $model_contact->attributes = $this->Input->post();
        if ($id) {
            $model->resume_id = $id;
            $model_contact->resume_id = $id;
        }
        $model->language_id = $this->language->getDefaultLanguage();
        if (!$id)
            $model_Personal->created = date("Y-m-d H:i:s");
//        if ($model->save()) {
//            Uri_helper::redirect("management/resumes");
//        }
        return $this->render('resumes/manage', [
                    'item' => $items,
                    'item_locations' => $locations,
                    'item_work' => $work,
                    'item_skills' => $skill,
                    'item_education' => $education,
                    'item_activities' => $activities,
                    'item_languages' => $languages,
                    'item_hobbies' => $hobbies,
                    'item_contacts' => $contacts,
                    'item_personal' => $personal,
                    'item_Martial' => $Martial,
                    'item_Nationality' => $Nationality
        ]);
    }

    ///////////////////////////////////Update Personal Information/////////////////////////////////////////////////////
    public function updatepersonalAction() {
        $this->permission('updatePersonal');
        $this->layout = 'ajax';
        $model_updatePersonal = new \modules\resumes\models\Resumes('edit');
        $id = $this->input->post('resume_id');
        $DOB = $this->input->post('date_of_birth');
        $marital = $this->input->post('marital_status_id');
        $nationality = $this->input->post('nationality_id');
        $model_updatePersonal->resume_id = $id;
        $model_updatePersonal->nationality_id = $nationality;
        $model_updatePersonal->marital_status_id = $marital;
        $model_updatePersonal->date_of_birth = $DOB;
        $model_updatePersonal->language_id = $this->language->getDefaultLanguage();
        if ($model_updatePersonal->save()) {
            return TRUE;
        }
    }

    ///////////////////////////////////Add New Contacts/////////////////////////////////////////////////////
    public function addcontactsAction() {
        $this->permission('addContacts');
        $this->layout = 'ajax';
//        print_r($_POST);
        if ($this->input->post('resume_id')) {
            $model_addContatcs = new \modules\resumes\models\Resume_contacts('add');
            $id = $this->input->post('resume_id');
            $contact_detail = $this->input->post('contact_detail');
            $contact_method = $this->input->post('contact_method');
            $model_addContatcs->resume_id = $id;
            $model_addContatcs->contact_method = $contact_method;
            $model_addContatcs->contact_detail = $contact_detail;
            $model_addContatcs->language_id = $this->language->getDefaultLanguage();
            if ($model_addContatcs->save())
                return true;
        } else
            return false;
    }

    ///////////////////////////////////Add New Location/////////////////////////////////////////////////////
    public function addlocationsAction() {
        $this->permission('addLocations');
        $this->layout = 'ajax';
        $model_addLocations = new \modules\resumes\models\Resume_locations('add');
        $id = $this->input->post('resume_id');
        $lat = $this->input->post('lat');
        $long = $this->input->post('long');
        $address = $this->input->post('address');
        $location = $this->input->post('location');
        $model_addLocations->resume_id = $id;
        $model_addLocations->location = $location;
        $model_addLocations->long = $long;
        $model_addLocations->lat = $lat;
        $model_addLocations->address = $address;
        $model_addLocations->language_id = $this->language->getDefaultLanguage();
        if ($model_addLocations->save())
            return TRUE;
    }

    ///////////////////////////////////Add New Work History/////////////////////////////////////////////////////
    public function addworksAction() {
        $this->permission('addWorks');
        $this->layout = 'ajax';
        $model_addWorks = new \modules\resumes\models\Resume_work_history('add');
        $id = $this->input->post('resume_id');
        $company = $this->input->post('company');
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $category = $this->input->post('category');
        $title = $this->input->post('title');
        $nationality = $this->input->post('nationality_id');
        $responsbilities = $this->input->post('responsbilities');
        $model_addWorks->resume_id = $id;
        $model_addWorks->nationality_id = $nationality;
        $model_addWorks->title = $title;
        $model_addWorks->category = $category;
        $model_addWorks->company = $company;
        $model_addWorks->to = $to;
        $model_addWorks->from = $from;
        $model_addWorks->responsbilities = $responsbilities;
        $model_addWorks->language_id = $this->language->getDefaultLanguage();
        if ($model_addWorks->save())
            return TRUE;
    }

    ///////////////////////////////////Add New Skills/////////////////////////////////////////////////////
    public function addskillsAction() {
        $this->permission('addSkills');
        $this->layout = 'ajax';
        $model_addSkills = new \modules\resumes\models\Resume_skills('add');
        $id = $this->input->post('resume_id');
        $content = $this->input->post('content');
        $category = $this->input->post('category');
        $model_addSkills->resume_id = $id;
        $model_addSkills->category = $category;
        $model_addSkills->content = $content;
        $model_addSkills->language_id = $this->language->getDefaultLanguage();
        if ($model_addSkills->save())
            return TRUE;
    }

    ///////////////////////////////////Add New Education/////////////////////////////////////////////////////
    public function addeduAction() {
        $this->permission('addEdu');
        $this->layout = 'ajax';
        $model_addEdu = new \modules\resumes\models\Resume_education('add');
        $id = $this->input->post('resume_id');
        $degree = $this->input->post('degree');
        $school = $this->input->post('school');
        $field = $this->input->post('field');
        $grade = $this->input->post('grade');
        $from_month = $this->input->post('from-month');
        $from_year = $this->input->post('from-year');
        $to_month = $this->input->post('to-month');
        $to_year = $this->input->post('to-year');
        $model_addEdu->resume_id = $id;
        $model_addEdu->school = $school;
        $model_addEdu->field = $field;
        $model_addEdu->degree = $degree;
        $model_addEdu->grade = $grade;
        $model_addEdu->from_month = $from_month;
        $model_addEdu->from_year = $from_year;
        $model_addEdu->to_month = $to_month;
        $model_addEdu->to_year = $to_year;
        $model_addEdu->language_id = $this->language->getDefaultLanguage();
        if ($model_addEdu->save())
            return TRUE;
    }

    ///////////////////////////////////Add New Activity/////////////////////////////////////////////////////
    public function addactivityAction() {
        $this->permission('addActivity');
        $this->layout = 'ajax';
        $model_addActivity = new \modules\resumes\models\Resume_activities('add');
        $id = $this->input->post('resume_id');
        $activity = $this->input->post('activity');
        $role = $this->input->post('role');
        $desc = $this->input->post('desc');
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $model_addActivity->resume_id = $id;
        $model_addActivity->activity = $activity;
        $model_addActivity->desc = $desc;
        $model_addActivity->role = $role;
        $model_addActivity->from = $from;
        $model_addActivity->to = $to;
        $model_addActivity->language_id = $this->language->getDefaultLanguage();
        if ($model_addActivity->save())
            return TRUE;
    }

    ///////////////////////////////////Add New Language/////////////////////////////////////////////////////
    public function addlanguageAction() {
        $this->permission('addLanguage');
        $this->layout = 'ajax';
        $model_addActivity = new \modules\resumes\models\Resume_languages('add');
        $id = $this->input->post('resume_id');
        $name = $this->input->post('name');
        $level = $this->input->post('level');
        $model_addActivity->resume_id = $id;
        $model_addActivity->name = $name;
        $model_addActivity->level = $level;
        $model_addActivity->language_id = $this->language->getDefaultLanguage();
        if ($model_addActivity->save())
            return TRUE;
    }

    ///////////////////////////////////Add New Hobby/////////////////////////////////////////////////////
    public function addhobbyAction() {
        $this->permission('addHobby');
        $this->layout = 'ajax';
        $model_addHoppy = new \modules\resumes\models\Resume_hobbies('add');
        $id = $this->input->post('resume_id');
        $name = $this->input->post('name');
        $model_addHoppy->resume_id = $id;
        $model_addHoppy->name = $name;
        $model_addHoppy->language_id = $this->language->getDefaultLanguage();
        if ($model_addHoppy->save())
            return TRUE;
    }

    public function deleteRAction($id = false) {
        $this->permission('deleteR');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\resumes\models\Resumes();
        $model->resume_id = $id;
        $model_activities = new \modules\resumes\models\Resume_activities();
        $model_activities->resume_id = $id;
        $model_contacts = new \modules\resumes\models\Resume_contacts();
        $model_contacts->resume_id = $id;
        $model_details = new \modules\resumes\models\Resume_details();
        $model_details->resume_id = $id;
        $model_education = new \modules\resumes\models\Resume_education();
        $model_education->resume_id = $id;
        $model_hobbies = new \modules\resumes\models\Resume_hobbies();
        $model_hobbies->resume_id = $id;
        $model_languages = new \modules\resumes\models\Resume_languages();
        $model_languages->resume_id = $id;
        $model_locations = new \modules\resumes\models\Resume_locations();
        $model_locations->resume_id = $id;
        $model_skills = new \modules\resumes\models\Resume_skills();
        $model_skills->resume_id = $id;
        $model_work = new \modules\resumes\models\Resume_work_history();
        $model_work->resume_id = $id;
        if ($model->delete()) {
            $model_activities->delete();
            $model_contacts->delete();
            $model_details->delete();
            $model_education->delete();
            $model_hobbies->delete();
            $model_languages->delete();
            $model_locations->delete();
            $model_skills->delete();
            $model_work->delete();
            Uri_helper::redirect("management/users");
        }
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $model = new \modules\resumes\models\Resumes();
        $model->resume_id = $id;
        if ($model->delete())
            Uri_helper::redirect("management/Resumes");
    }

}
