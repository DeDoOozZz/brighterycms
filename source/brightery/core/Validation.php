<?php

class Validation
{
    private $errors = 0;
    private $error_messages = [];
    private $config;
    private $fields;
    private $systemValidationMessages;
    private $input;
    private $language;
    private $upload;
    private $model;

    public function __construct()
    {
        Log::set('Initialize Validation class');
        $this->input = &Brightery::SuperInstance()->Input;
        $this->setupSystemValidationMessages();
    }

    public function errors_array()
    {
        return $this->error_messages;
    }

    private function setupSystemValidationMessages()
    {
        $this->language = &Brightery::SuperInstance()->Language;
        if (isset($this->language))
            $defaultLanguage = Brightery::SuperInstance()->language->getDefaultLanguage(true);
        $this->systemValidationMessages = Brightery::loadFile([ROOT, 'languages', $defaultLanguage, 'system.php']);
    }

    public function errors()
    {
        $this->config = Brightery::SuperInstance()->Config->get('Validation.error_validation_message_format');
        $content = $this->config['messages_content_open_tag'];
        foreach ($this->errors_array() as $message) {
            $content .= $this->config['message_item_open_tag'];
            $content .= $message;
            $content .= $this->config['message_item_close_tag'];
        }
        $content .= $this->config['messages_content_close_tag'];
        return $content;
    }

    public function validate(& $model)
    {
        if ($_POST)
            return $this->run($model);
        else
            return false;
    }

    public function run(& $model)
    {
        $this->model = &$model;
        $rules = $model->rules();
        $this->fields = $this->field_names($this->model->fields());
        if (isset($rules['all']))
            $avRules = $rules['all'];
        else
            $avRules = [];
        if (isset($rules[$this->model->_form]))
            $avRules = array_merge($avRules, $rules[$this->model->_form]);
        foreach ($avRules as $field => $rules) // FOREACH FIELD
            foreach ($rules as $rule => $options) // FOREACH VALIDATION RULE
                if (!is_numeric($rule))
                    $this->validate_field($this->model, $field, $rule, $options);
                else
                    $this->validate_field($this->model, $field, $options);

        if ($this->errors)
            return FALSE;
        return TRUE;
    }

    private function field_names($fields)
    {
        $arr = [];
        foreach ($fields as $k => $field) {
            $arr[$k] = $this->language->phrase($field);
        }
        return $arr;
    }

    private function getSystemValidationMessages($rule)
    {
        return isset($this->systemValidationMessages[$rule]) ? $this->systemValidationMessages[$rule] : Brightery::error_message("Error message is not set for the rule $rule");
    }

    private function validate_field($model, $field, $rule, $options = null)
    {
        $_rule = "_" . $rule;
        if (is_array($options))
            $params = array_merge([$field], $options);
        else
            $params = [$field];
        if (method_exists($model, $_rule)) {
            if (!call_user_func_array([$model, $_rule], $params)) {
                $this->errors++;
                $this->error_messages[$field] = sprintf($this->getSystemValidationMessages($rule), isset($this->fields[$field]) ? $this->fields[$field] : $field);
            }
        } elseif (method_exists($this, $_rule)) {
            if (!call_user_func_array([$this, $_rule], $params)) {
                $this->errors++;
                $this->error_messages[$field] = sprintf($this->getSystemValidationMessages($rule), isset($this->fields[$field]) ? $this->fields[$field] : $field);
            }
        } else {
            return Brightery::error_message("This validation rule \"$rule\" is not exists.", "Validation");
        }
    }

    public function get_error_messages()
    {
        return $this->error_messages;
    }

    public function setValidationMessage($rule, $message)
    {
        $this->systemValidationMessages[ltrim($rule, '_')] = $message;
    }

    /*###########################################################################
      # VALIDATION RULES                                                        #
      ###########################################################################*/

    private function _numeric($str)
    {
        if ($this->input->post($str) == NULL)
            return TRUE;
        return is_numeric($this->input->post($str));
    }

    private function _phone($str)
    {
        if ($this->input->post($str) == NULL)
            return TRUE;
        return is_numeric($this->input->post($str));
    }

    private function _required($str)
    {
        if(is_array($str))
            if( ! isset(array_values($str)[0]))
                return FALSE;
            else
                $str = array_values($str)[0];
        if (strlen($this->input->post($str)) === 0)
            return FALSE;
        return TRUE;
    }

    private function _dropdown($str, $available_values = [])
    {
        if ($this->input->post($str) == NULL)
            return TRUE;
        return in_array($this->input->post($str), $available_values);
    }

    private function _url($url)
    {
        if ($this->input->post($url) == NULL)
            return TRUE;
//        $pattern = "/^((ht|f)tp(s?)\:\/\/|~/|/)?([w]{2}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?/";
        $pattern = "/([a-zA-Z_@.]+)/";
        if ( ! preg_match($pattern, $this->input->post($url))) {
            return FALSE;
        }

        return TRUE;
    }

    private function _real_url($url)
    {
        if ($this->input->post($url) == NULL)
            return TRUE;
        return @fsockopen($this->input($url), 80, $errno, $errstr, 30);
    }

    private function _datetime($val)
    {
        if ($this->input->post($val) == NULL)
            return TRUE;
        if (!preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $this->input->post($val)))
            return FALSE;
        else
            return TRUE;
    }

    private function _time($val)
    {
        if ($this->input->post($val) == NULL)
            return TRUE;
        if (!preg_match("/([0-9]{2}):([0-9]{2}):([0-9]{2})/", $this->input->post($val)))
            return FALSE;
        else
            return TRUE;
    }

    private function _date($str)
    {
        if ($this->input->post($str) == NULL)
            return TRUE;
        if (!preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", $this->input->post($str)))
            return FALSE;
        else
            return TRUE;
    }

    private function _email($str)
    {
        if ($this->input->post($str) == NULL)
            return TRUE;
        return true;
    }

    private function _emails($str)
    {
        if ($this->input->post($str) == NULL)
            return TRUE;
        return true;
    }
    
    private function _matches($str, $str2)
    {
        if ($this->input->post($str) == $this->input->post($str2))
            return TRUE;
        return true;
    }

    private function _unique($str, $table, $column, $extra = null)
    {
        if ($this->input->post($str) == NULL)
            return TRUE;
        $this->db = &Brightery::SuperInstance()->Database;
        if ($extra)
            $extra = " AND $extra";

        $data = $this->db->query('SELECT COUNT(*) as count FROM ' . $table . ' WHERE ' . $column . '="' . $this->input->post($str) .'"'. $extra)->row()->count;
        if ($data) {
            return false;
        }
        return true;
    }

    private function _file($str, $config = null)
    {
        if (!isset($config['required']) || $config['required'] == FALSE)
            if (!isset($_FILES[$str]) || $_FILES[$str]['error'] !== 0) {
                return true;
            }
        $this->upload = &Brightery::SuperInstance()->upload;
        $this->upload->initialize($config);
        if ($this->upload->do_upload($str)) {
            $this->model->{$str . '_result'} = $this->upload->data();
            $this->model->$str = $this->upload->data('file_name');
            return true;
        } else {
            return false;
        }
    }

}
