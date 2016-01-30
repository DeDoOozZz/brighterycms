<?php namespace modules\clients\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Clients Model
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 **/

class Clients extends \Model
{
    public $_table = 'clients';
    public $_fields = [
        'client_id' => ['int', 11, 'PRI'],
        'name' => ['varchar'],
        'image' => ['text'],
        
    ];

    public function rules()
    {
        return [
            'all' => [
                'name' => ['required'],
            ],
             'add' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/clients/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => TRUE
                        ]
                    ]],
            ],
            'edit' => [
                'image' => ['file' => [
                        [
                            'upload_path' => "./cdn/clients/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'required' => FALSE
                        ]
                    ]],
            ]
        ];
    }

    public function fields()
    {
        return [
            'name' => 'Name',
            'image' => 'Image',
          
        ];
    }

}
