<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Seo Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module pages
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/seo
 *
 **/
class SeoController extends Brightery_Controller {

    protected $layout = 'ajax';

    public function __construct() {
        parent::__construct();
        $this->language->load("pages");
    }

    public function urlAction() {
        $str = $this->input->get('url');

        $replace=array(); $delimiter='-';
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean =  $str;
        $clean = preg_replace("/[^a-zA-Z0-9اأإبتثجحخدذرزسشصضطظعغفقكلمنهويىة\/_|+ -]/", '', $clean);
        $clean = (trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        echo json_encode(['url' => Uri_helper::url('page', $clean), 'permalink'=> $clean]);
    }
}
