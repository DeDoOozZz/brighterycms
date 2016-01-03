<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Categories Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_categories extends \Model {

    public $_table = 'commerce_categories';
    public $_fields = [
        'commerce_category_id' => ['int', 11, 'PRI'],
        'title' => ['varchar', 255],
        'parent' => ['int', 11],
        'seo' => ['varchar', 255],
        'language_id' => ['varchar', 255],
        'image' => ['text'],
        'description' => ['text'],
        'featured' => ['enum', ['yes', 'no']],
    ];

    public function rules() {
        return [
            'all' => [
                'title' => ['required'],
                'parent' => ['required', 'numeric'],
                'seo' => ['required'],
            ],
             'add' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => False
                        ]
                ]],
            ]
            ,
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/commerce/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                ]],
            ]];
    }

    public function fields() {
        return [
            'title' => 'title',
            'parent' => 'parent',
            'seo' => 'seo',
            'image' => 'image',
        ];
    }
    
    public function getSubCategories($id){
        return  $this->Database->query("SELECT `commerce_categories`.*"
                        . "FROM `commerce_categories` "
                        . "WHERE commerce_categories.parent='$id'")->result();

    }
    
    public function tree(){
        $cats = [];
        foreach($this->getSubCategories(0) as $main_cat){
            $cats[] = ['main'=> $main_cat, 'sub' => $this->getSubCategories($main_cat->commerce_category_id)];
        }
        return $cats;
    }
    
    public function getMainCategory($category_id){
        if($cat = $this->database->where('commerce_category_id', $category_id)->get('commerce_categories')->row())
        {
            if($cat->parent == 0)
                return $cat;
            else
                return $this->getMainCategory($cat->parent);
        }
    }

}
