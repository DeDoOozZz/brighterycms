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
        
    ];

    public function rules()
    {
        return [
            'all' => [
                'question' => ['required'],
                'answer' => ['required'],
                'visibility_status_id' => ['required'],
            ],
        ];
    }

    public function fields()
    {
        return [
            'question' => 'Question',
            'answer' => 'Answer',
            'created' => 'Created',
            'visibility_status_id' => 'Visibility',
        ];
    }

}
