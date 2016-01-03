<?php


function commerce() {
    $cat_model = new \modules\commerce\models\Commerce_categories();
    Brightery::SuperInstance()->load->library('cart');
    return ['categories' => $cat_model->tree(), 'cart' => Brightery::SuperInstance()->cart];
}