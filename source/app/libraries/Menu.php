<?php

/**
 * Created by PhpStorm.
 * User: muhammad
 * Date: 8/12/15
 * Time: 5:34 PM
 */
class Menu
{
    public function getCustomMenu($param)
    {
        $links = [];
        $menu = Brightery::SuperInstance()->Database->where('link_type_id', $param)->get('links')->result();
        foreach($menu as $item){
            $links[] = [
                'name' => $item->name,
                'url' => strpos($item->url, 'http') ? $item->url : Uri_helper::url($item->url)
            ];
        }

        return $links;
    }
    public function getMenu($interface)
    {
        $menu = Brightery::SuperInstance()->Config->get('Menu.' . $interface);
        array_walk_recursive($menu, function(&$value, $key){
            if($key == 'title')
                $value = $this->getTitle($value);
        });

        return $menu;
    }

    private function getTitle($str) {
        $res = Brightery::SuperInstance()->Language->phrase('menu_'.$str);
        return $res !== 'menu_' . $str ? $res : $str;
    }

}