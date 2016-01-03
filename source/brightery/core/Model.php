<?php

/**
 * @package Brightery Model
 * @property string $select Customized select query string
 * @property string $table Table name
 * @property array $joins array(joined_table => joining_conddition)
 * @property array $primary_keys array of master and joined table primary keys
 * @property array $attributes array of affected table attributes
 * @property integer $limit Limit query results
 * @property integer $offset the offset
 * @property array $order_by array('id' => 'DESC')
 *
 * @version 1.0
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 */
abstract class Model {

    public $_select = NULL;
    public $_table;
    public $_primary_key = null;
    public $_unique_keys = [];
    public $_joins = NULL;
    public $_limit = NULL;
    public $_offset = 0;
    public $_where = null;
    public $_where_in = null;
    public $_set = [];
    public $_like = [];
    public $_order_by = NULL;
    public $attributes = [];
    public $_form = false; // THE VALIDATION FOR WHICH FORM
    protected $_fields = [];

    public function __construct($form = null) {
        Log::set('Initialize Model class');
        if ($form !== false)
            $this->_form = $form;
        $this->setKeys();
    }

    private function setKeys() {
        foreach ($this->_fields as $fieldKey => $fieldValue) {
            if (isset($fieldValue[2]) && $fieldValue[2] == 'PRI')
                $this->_primary_key = $fieldKey;
            if (isset($fieldValue[2]) && $fieldValue[2] == 'UNI')
                $this->_unique_keys[] = $fieldKey;
        }
    }

    public function getPrimaryKey() {
        if (isset($this->_primary_key))
            return $this->_primary_key;
    }

    abstract public function rules();

    public function validate() {
        if (!$_POST)
            return false;
        if ($this->_form !== FALSE)
            return $this->Validation->run($this);
        else
            return TRUE;
    }

    /**
     * __get magic
     *
     * return super instance's objects
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key) {
        $SI = &Brightery::SuperInstance();
        if (isset($SI->{ucfirst($key)}))
            return $SI->{ucfirst($key)};
        elseif (isset($this->attributes[$key]))
            return $this->attributes[$key];
    }

    public function __set($attr, $value) {
        if ($value !== false)
            $this->attributes[$attr] = $value;
        else
            unset($this->attributes[$attr]);
    }

    public function reset() {
        $this->attributes = null;
        $this->_where = null;
    }

    public function set($key, $value) {
        if (is_array($key) && !$value) {
            foreach ($key as $k => $v) {
                $this->_set[$k] = $v;
            }
        } else
            $this->_set[$key] = $value;
    }

    public function like($key, $value) {
        if (is_array($key) && !$value) {
            foreach ($key as $k => $v) {
                $this->_like[$k] = $v;
            }
        } else
            $this->_like[$key] = $value;
    }

    public function where_in($attr, $value = null) {
        $this->_where_in[$attr] = $value;
    }

    public function where($attr, $value = null) {
        if ($value === null)
            $this->_where[$attr] = $attr;
        elseif ($value !== false)
            $this->_where[$attr] = $attr . ' = "' . $value . '"';
        else
            unset($this->_where[$attr]);
    }

    public function get($num_rows = FALSE) {
        if ($this->_order_by === null && $this->getPrimaryKey())
            $this->_order_by = [$this->getPrimaryKey() => 'DESC'];

        if ($this->_select !== NULL)
            $this->Database->select($this->_select);

        if ($num_rows)
            $this->Database->select("COUNT(*) as count");

        $row = FALSE;

        if ($this->attributes)
            foreach ($this->attributes as $key => $value) {
                if (!in_array($key, array_keys($this->_fields)))
                    continue;
                $this->Database->where($key, $value);
                if ($key == $this->getPrimaryKey() || in_array($key, $this->_unique_keys))
                    $row = TRUE;
            }
        if ($this->_where)
            foreach ($this->_where as $value) {
                $this->Database->where($value);
            }
        if ($this->_where_in)
            foreach ($this->_where_in as $k => $value) {
                $this->Database->where($k, $value);
            }
        if ($this->_like)
            foreach ($this->_like as $k => $value) {
                $this->Database->like($k, $value);
            }

        if ($this->_order_by !== NULL)
            foreach ($this->_order_by as $key => $value) {
                $this->Database->order_by($key, $value);
            }

        if ($this->_joins !== NULL)
            foreach ($this->_joins as $key => $value) {
                $type = isset($value[1]) ? $value[1] : 'INNER';
                $this->Database->join($key, $value[0], $type);
            }

        if (!$num_rows) {
            if ($this->_limit !== NULL)
                $this->Database->limit($this->_limit, $this->_offset);
        }

        $query = $this->Database->get($this->_table);

        if ($num_rows)
            return $query->row()->count;

        if ($row)
            return $query->row();
        else
            return $query->result();
    }

    public function save($noValidation = FALSE) {
        if (!$noValidation)
            if (!$this->validate())
                return;
        $update = FALSE;

        if ($this->_where) {
            foreach ($this->_where as $where_k => $where_v) {
                $update = $where_v;
                $this->Database->where($where_k, $where_v);
            }
        }
        if ($this->attributes)
            foreach ($this->attributes as $key => $value) {

                if (!in_array($key, array_keys($this->_fields)))
                    continue;

                if ($key == $this->_primary_key) {
                    $update = $value;
                    $this->Database->where($key, $value);
                } else
                    $this->Database->set($key, $value);
            }

        if ($this->_set)
            foreach ($this->_set as $key => $value) {
                $this->Database->set($key, $value);
            }


        if ($update) {
            $this->Database->update($this->_table);
            return $update;
        } else {
            $this->Database->insert($this->_table);
            return $this->Database->insert_id();
        }
    }

    public function delete() {
        if ($this->attributes)
            foreach ($this->attributes as $key => $value) {
                $this->Database->where($key, $value);
            }
        return $this->Database->delete($this->_table);
    }

}
