<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Faqs 
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module faqs
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/faqs
 * @controller FaqsController
 *
 * */
class FaqsController extends Brightery_Controller {

    protected $layout = 'classfied';

    public function indexAction() {
        $this->Language->load('faqs');
        $faq = new \modules\faqs\models\Faqs();
        $faq->_select = 'faq_id, question, answer, answered';
        return $this->render('faqs/index', [
                    'items' => $faq->get()
        ]);
    }

}
