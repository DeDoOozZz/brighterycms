<?php

return [
    'management' => [
        'commerce' => [
            'title' => 'commerce',
            'icon' => 'fa fa-shopping-cart',
            'sub' => [
                'categories' => [
                    'title' => 'categories',
                    'url' => 'management/commerce_categories',
                    'icon' => 'fa fa-sitemap'
                ],
                 'products' => [
                    'title' => 'products',
                    'url' => 'management/commerce_products',
                    'icon' => 'fa fa-cubes'
                ],
                 'brands' => [
                    'title' => 'brands',
                    'url' => 'management/commerce_brands',
                    'icon' => 'fa fa-bookmark'
                ],
                
//                'category_attributes' => [
//                    'title' => 'category_attributes',
//                    'url' => 'management/commerce_category_attributes',
//                    'icon' => 'fa fa-tasks'
//                ],
                
                'orders' => [
                    'title' => 'orders',
                    'url' => 'management/commerce_orders',
                    'icon' => 'fa fa-fax'
                ],
                
                'invoices' => [
                    'title' => 'invoices',
                    'url' => 'management/commerce_invoices',
                    'icon' => 'fa fa-print'
                ],
                
               
                
//                'shares' => [
//                    'title' => 'shares',
//                    'url' => 'management/commerce_shares',
//                    'icon' => 'fa fa-retweet'
//                ],
                
                'offers' => [
                    'title' => 'offers',
                    'url' => 'management/commerce_products_offers',
                    'icon' => 'fa fa-bookmark'
                ],
                
                'payment_method' => [
                    'title' => 'payment_method',
                    'url' => 'management/commerce_payment_method',
                    'icon' => 'fa fa-money'
                ],

            ],
        ],
    ],
];
