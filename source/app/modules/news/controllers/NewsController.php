<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pages Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module pages
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/pages
 * @controller Pages
 *
 * */
class NewsController extends Brightery_Controller {

    protected $interface = 'frontend';
    protected $layout = 'default';

    public function indexAction() {
        $this->Language->load('faqs');
        $faq = new \modules\faqs\models\Faqs();
        $faq->_select = 'faq_id, question, answer, answered';
        return $this->render('faqs/index', [
                    'items' => $faq->get()
        ]);
    }

}
