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
 * @controller Clinic_xray_negativeController
 *
 * */
class Clinic_xray_negativeController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true; 

    public function manageAction($op = null, $id = null) {
        if(! $id or ! $op )
            return Brightery::error404();
  
        $this->layout = 'ajax';
        $this->permission('manage');
        
        $this->language->load('clinic_patients');
        $xrays = new \modules\clinic\models\Clinic_xray_negative();
        if ($op == 'add') {
            $xrays->attributes['user_id'] = $id;
        }
        else
        {
           $xrays->clinic_xray_negative_id = $id;
           $data['xray']= $xrays->get();
        }
        
        $xrays->attributes['title'] = $this->input->post('title');
        $xrays->attributes['description'] = $this->input->post('description');
        $xrays->attributes['image'] = $this->input->post('image');
        
        $data['op'] = $op;
        $data['id'] = $id;
        if(!$_POST){
            return $this->render('clinic_patients/xrays', $data);
        }else
        
        
        if ($sid = $xrays->save())
            return json_encode(['sucess' => 1, 'id'=> $sid, 'title' => $this->input->post('title'), 'description' => $this->input->post('description'), 'image' => $this->input->post('image')]);
        else
            return json_encode(['sucess' => 0, 'errors' => $this->validation->errors()]);
    }
    
    public function deleteAction($id = false) {
        $this->permission('delete');
        if (!$id)
            return Brightery::error404();
        $xrays = new \modules\clinic\models\Clinic_xray_negative();
        $xrays->clinic_xray_negative_id = $id;

        if ($sid = $xrays->delete())
            return json_encode(['sucess' => 1]);
    }
}
