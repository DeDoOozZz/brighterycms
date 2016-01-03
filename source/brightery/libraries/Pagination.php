<?php

/**
 * Pagination
 * @package Brightery CMS
 * @version 1.0
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 */
class Pagination
{
    private $config = [
        'limit' => 20,
        'maximum_pages' => 5,
        'url' => null,
        'postfix_url' => null,
        'total' => null,
        'offset' => null,
        'design' => [
            'open_tag' => '<ul class="pagination pagination-sm no-margin">',
            'close_tag' => '</ul>',
            'prev_btn' => '<li><a href="%s"><i class="fa fa-chevron-left"></i></a></li>',
            'next_btn' => '<li><a href="%s"><i class="fa fa-chevron-right"></i></a></li>',
            'active_item' => '<li class="active"><a href="%s">%d</a></li>',
            'regular_item' => '<li><a href="%s">%d</a></li>',
        ]
    ];

    public function __construct()
    {
        Log::set("Initialize Pagination Class");
        $this->config = array_merge($this->config, Brightery::SuperInstance()->Config->get('Pagination'));
    }

    public function generate($config = [])
    {
        $this->config = array_merge($this->config, $config);
        $pages = ceil($this->config['total'] / $this->config['limit']);
        $current_page = ceil($this->config['offset'] / $this->config['limit']) + 1;
        $prev = ($this->config['offset'] - $this->config['limit']);
        $next = ($this->config['offset'] + $this->config['limit']);

        $html = $this->config['design']['open_tag'];

        if ($prev >= 0)
            $html .= sprintf($this->config['design']['prev_btn'], $this->prepareUrl($prev));

        $range = $this->getRange($pages, $current_page);

        for ($i = $range['start']; $i <= $range['end']; $i++) {
            $html .= $current_page == $i ? sprintf($this->config['design']['active_item'], $this->prepareUrl(($i - 1) * $this->config['limit']), $i) : sprintf($this->config['design']['regular_item'], $this->prepareUrl(($i - 1) * $this->config['limit']), $i);
        }

        if ($next <= $this->config['total'])
            $html .= sprintf($this->config['design']['next_btn'], $this->prepareUrl($next));
        $html .= $this->config['design']['close_tag'];
        return $html;
    }

    private function prepareUrl($number)
    {
        if ($this->config['url'])
            return $this->config['url'] . '/' . $number . $this->config['postfix_url'];
        return null;
    }
    private function getRange($pages, $current_page) {
        if ($pages > $this->config['maximum_pages']){



            if($current_page + 2 <= $pages && $current_page - 2 >= 1) {
                $range = [
                    'start' => $current_page - 2,
                    'end' => $current_page + 2
                ];
            }

            if($current_page + 2 > $pages) {
                $range = [
                    'start' => $pages - ($this->config['maximum_pages'] - 1 ),
                    'end' => $pages
                ];
            }

            if($current_page - 2 <= 1) {
                $range = [
                    'start' => 1,
                    'end' => $this->config['maximum_pages']
                ];
            }



            if($current_page == $pages) {
                $range['start'] = ($pages - ($this->config['maximum_pages'] - 1));
                $range['end'] = $range['start'] + ($this->config['maximum_pages'] - 1);
            }

//            for($i = 1; $i < $pages; $i ++){
//                if($current_page == $pages - $i) {
//                    $range['start'] = $pages - $this->config['maximum_pages']) - $i+1;
//                    $range['end'] = ($range['initial'] + $this->config['maximum_pages']) - $i+1;
//                }
//            }


//            if(($pages - $current_page) ) {
//                $range['initial'] = ($pages - ($this->config['maximum_pages'] - 2));
//            }


        }
        else
            $range = ['end' => $pages,'start' => 1];

        return $range;
    }

}