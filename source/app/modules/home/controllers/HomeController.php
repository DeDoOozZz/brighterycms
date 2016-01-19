<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Home Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface frontend
 * @module home
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/home
 * @controller HomeController
 *
 * */
class HomeController extends Brightery_Controller
{
    protected $layout = 'default';

    public function __construct() {
        parent::__construct();
        // CHECK THE SUITABLE HOME PAGE
        if($setting = $this->module->getSettings($this->_module))
            if(isset($setting->default_home_page) && $setting->default_home_page != 'home')
                Uri_helper::redirect($setting->default_home_page);
    }

    public function indexAction(){
        $this->language->load('welcome');

//      --------start sliders---------
//        $this->language->load('sliders');
//        $sliders = new \modules\sliders\models\Sliders();
//        $sliders->_select = 'slider_id, title, caption, url';
//        $slides = $sliders->get();
        $slides = null;
//      -----------end sliders--------------

//      ----------start news home-----------
        $this->Language->load('blog_posts');
        $posts = new \modules\blog\models\Blog_posts();
        $posts->_select = 'blog_post_id,title,image,short_content,seo';
        $posts->_limit = 4;
//        $posts->_orderby = 4;
        $post = $posts->get();
//      ----------end news home------------

//      -------start testonmials home------
        $this->Language->load('testimonials');
        $testimonials = new \modules\testimonials\models\Testimonials();
        $testimonials->_select = 'testimonial_id,client_name,client_position,message';
        $testimonial = $testimonials->get();
//      --------end testonmials home-------

//      ----------start clients home-----------
//        $this->Language->load('clients');
//        $clients = new \modules\blog\models\Clients();
//        $clients->_select = 'client_id,name,image';
//        $client = $clients->get();
        //      ----------end clients home------------


        return $this->render('home', [
            'slides' => $slides,
            'post' => $post,
            'testimonial' => $testimonial,
//            'client'=>$client
        ]);
    }

}
