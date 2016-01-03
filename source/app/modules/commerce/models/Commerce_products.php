<?php namespace modules\commerce\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Commerce Products Model
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * */
class Commerce_products extends \Model {

    public $_table = 'commerce_products';
    public $_fields = [
        'commerce_product_id' => ['int', 11, 'PRI'],
        'name' => ['varchar', 255],
        'commerce_category_id' => ['int', 11],
        'price' => ['double'],
        'type' => ['enum'],
        'discount' => ['float'],
        'commerce_brand_id' => ['int', 11],
    ];

    public function rules() {
        return [
            'all' => [
                'name' => ['required'],
                'commerce_category_id' => ['required', 'numeric'],
                'price' => ['required'],
                'discount' => ['required'],
                'commerce_brand_id' => ['required'],
            ],];
    }

    public function fields() {
        return [
            'name' => 'Name',
            'commerce_category_id' => 'Category',
            'price' => 'Price',
            'type' => 'Type',
            'discount' => 'Discount',
            'commerce_brand_id' => 'Brand',
        ];
    }

    public function discount($price, $discount = 0) {
        return $price-($price*$discount/100);
    }
    
     public function getCategoryProducts($id){
         return $this->Database->query("SELECT * "
                        . "FROM `commerce_products` "
                        . "WHERE commerce_category_id='$id' LIMIT 10")->result();
    }

    public function getProductPrimaryImage($id) {
        if($image = $this->Database->query("SELECT product_image FROM commerce_product_images WHERE commerce_product_id = '$id' ORDER BY `primary` DESC LIMIT 1 ")->row())
            return $image->product_image;
        else
            return 'default_image.png';
    }
}
