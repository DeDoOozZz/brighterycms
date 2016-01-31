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
 * @link http://store.brightery.com/module/general/patients
 * @controller Clinic_patients_notes
 *
 * */
class Clinic_patients_notesController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function manageAction($op = null, $id = null) {
        if (!$id and ! $op)
            Brightery::error404();

        $this->layout = 'ajax';
        $this->permission('manage');

        $this->language->load('clinic_patients');
        $notes = new \modules\clinic\models\Clinic_patients_notes();
        if ($op == 'add') {
            $notes->user_id = $id;
        } else if($op == 'edit') {
            $notes->clinic_patient_note_id = $id;
            $data['note'] = $notes->get();
        }

        $notes->note = $this->input->post('note');
        $data['op'] = $op;
        $data['id'] = $id;
        if (!$_POST) {
            return $this->render('clinic_patients/notes', $data);
        } else
        if ($sid = $notes->save())
            return json_encode(['sucess' => 1, 'id' => $sid, 'note' => $this->input->post('note')]);
        else
            return json_encode(['sucess' => 0, 'errors' => $this->validation->errors()]);
    }

    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $notes = new \modules\clinic\models\Clinic_patients_notes();
        $notes->clinic_patient_note_id = $id;

        if ($sid = $notes->delete())
            return json_encode(['sucess' => 1]);
    }

}
