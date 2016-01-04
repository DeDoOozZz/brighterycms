<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Patients Controller
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface management
 * @module clinic
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/clinic
 * @controller Clinic_patient_diseasesController
 * */
class Clinic_patient_diseasesController extends Brightery_Controller {

    protected $layout = 'default';

    public function manageAction($op = null, $id = null) {
        if (!$id or ! $op)
            return Brightery::error404();

        $this->layout = 'ajax';
        $this->permission('manage');

        $this->language->load('clinic_patients');
        $diseases = new \modules\clinic\models\Clinic_patient_diseases();
        if ($op == 'add') {
            $diseases->attributes['user_id'] = $id;
        } else {
            $diseases->clinic_patient_disease_id = $id;
            $data['disease'] = $diseases->get();
        }

        $diseases->attributes['clinic_disease_template_id'] = $this->input->post('clinic_disease_template_id');
        $diseases->attributes['note'] = $this->input->post('note');

        $data['op'] = $op;
        $data

                ['id'] = $id;

        $data['disease'] = Form_helper::queryToDropdown('clinic_disease_templates', 'clinic_disease_template_id', 'title');

        if (!$_POST) {
            return $this->render('clinic_patients/diseases', $data);
        } else {
            if ($sid = $diseases->save())
                return json_encode(['sucess' => 1, 'id' => $sid, 'disease' => $this->input->post('clinic_disease_template_id'),
                    'note' => $this->input->post('note')]);
//            (['sucess' => 1, 'id' => $sid, 'note' => $this->input->post('note')]);
            else
                return json_encode(['sucess' => 0, 'errors' => $this->validation->errors()]);
        }
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $diseases = new \modules\clinic\models\Clinic_patient_diseases();
        $diseases->clinic_patient_disease_id = $id;

        if ($sid = $diseases->delete())
            return json_encode(['sucess' => 1]);
    }

}
