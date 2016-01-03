<?php namespace modules\faqs\models; defined('ROOT') OR exit('No direct script access allowed');
/**
 * Faqs Model
 *
 * @package Brightery CMS
 * @author Marwa El-manawy <marwa.elmanawy@brightery.com>
 * @version 1.0
 **/

class Faqs extends \Model
{
    public $_table = 'faqs';
    public $_fields = [
        'faq_id' => ['int', 11, 'PRI'],
        'language_id' => ['varchar'],
        'question' => ['text'],
        'answer' => ['text'],
        'created' => ['datetime'],
        'answered' => ['datetime'],
        'visibility_status_id' => ['datetime'],
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
