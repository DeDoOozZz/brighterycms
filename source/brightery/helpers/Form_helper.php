<?php

/**
 * Form Helper
 *
 * @package Brightery CMS
 * @version 1.0
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 */
class Form_helper
{
    private static $_set_value = [];

    public function open($action = null, $jsValidation = false, $multipart = false, $extras = null)
    {
        if ($action)
            $action = " action=\"$action\"";
        if ($multipart)
            $multipart = " enctype=\"multipart/form-data\"";
//        if($jsValidation)
//            return json_encode($jsValidation->rules());
        return "<form{$action} method=\"post\"{$multipart}{$extras}>";
    }

    public function close()
    {
        return "</form>";
    }

    public function text($name, $defaultValue = false, $extras = null)
    {
        return $this->input('text', $name, $defaultValue, $extras);
    }

    public function input($type, $name, $defaultValue = false, $extras = null)
    {
        return "<input type=\"$type\" name=\"$name\" value=\"$defaultValue\" $extras>";
    }

    public function dropdown($name, $values = [], $default_value = null, $extras = null)
    {
        $content = "<select name=\"$name\" $extras>";
        foreach ($values as $key => $value) {
            if ($default_value == $key)
                $content .= "<option selected=\"selected\" value=\"$key\">$value</option>";
            else
                $content .= "<option value=\"$key\">$value</option>";
        }
        $content .= "</select>";
        return $content;
    }

    public function value($field, $value = NULL, $default = NULL)
    {
        if (isset($_POST[$field]))
            if (is_array($_POST[$field])) {
                if (!isset(self::$_set_value[$field]))
                    self::$_set_value[$field] = 0;
                else
                    self::$_set_value[$field]++;
                return $_POST[$field][self::$_set_value[$field]];
            } else
                return $_POST[$field];
        elseif (!empty($value))
            return $value;
        else
            return $default;
    }

    public function checked($field, $value, $default = false)
    {
        if (is_array($_REQUEST[$field]) && in_array($value, $_REQUEST[$field])) {
            return 'checked="checked"';
        } elseif ($_REQUEST[$field] == $value) {
            return 'checked="checked"';
        } else
            if ($default)
                return 'checked="checked"';
            else
                return;
    }
    public function in_array($value, $array)
    {
        return in_array($value, $array);
    }

    public static function objToDropdown($obj, $key, $value, $res = [])
    {
//        $res[''] = Brightery::SuperInstance()->Language->phrase('select_from_menu');
        foreach ($obj as $item) {
            $res[$item->$key] = $item->$value;
        }
        return $res;
    }

    public static function queryToDropdown($databaseTable, $key, $value, $selectFromMenuText = null, $additionalConditions = null)
    {
        $menu = Brightery::SuperInstance()->Database->query("SELECT `$key`, `$value` FROM `$databaseTable` $additionalConditions ORDER BY `$value` ASC")->result();
        $resultMenu = [];
        if ($selectFromMenuText === NULL) {
            $resultMenu[''] = Brightery::SuperInstance()->Language->phrase('select_from_menu');
        } elseif ($selectFromMenuText !== FALSE) {
            $resultMenu = array_merge($resultMenu, $selectFromMenuText);
        }
        foreach ($menu as $mItem) {
            $resultMenu[$mItem->{$key}] = $mItem->{$value};
        }
        return $resultMenu;
    }

    public static function arrayToDropdown(array $arr)
    {
        $resultMenu = [];
        $resultMenu[''] = Brightery::SuperInstance()->Language->phrase('select_from_menu');
        $resultMenu = array_merge($resultMenu, $arr);
        return $resultMenu;
    }

    public static function fullqueryToDropdown($query, $key, $value, $selectFromMenuText = null)
    {
        $menu = Brightery::SuperInstance()->Database->query($query)->result();
        $resultMenu = [];
        if ($selectFromMenuText !== NULL) {
            $resultMenu[''] = Brightery::SuperInstance()->Language->phrase('select_from_menu');
        }
        foreach ($menu as $mItem) {
            $resultMenu[$mItem->{$key}] = $mItem->{$value};
        }
        return $resultMenu;
    }

}
