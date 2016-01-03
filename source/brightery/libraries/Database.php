<?php

class Database
{
    protected $where = [];
    protected $set = [];
    protected $from;
    protected $join;
    protected $query;
    protected $query_queue;
    protected $select = '*';
    protected $groupBy;
    protected $last_query;
    protected $having;
    protected $orderBy;
    protected $limit;
    public $connection = 'default';
    private $currentConnection;
    protected $db;

    /**
     * Database construct
     * @param type $param
     */
    public function __construct($param = FALSE)
    {
        Log::set("Initialize Database Class");
        $this->establish_connection('default');
    }

    public function __call($name, $arguments)
    {
        return $this->db->{$name}($arguments);
    }

    public function establish_connection($connection)
    {
        if (!$this->connection($connection))
            $this->connection($connection . '_replication', true);
    }

    public function connection($connection, $replication = false)
    {
        // ESTABLISH A CONNECTION
        $this->currentConnection['host'] = Brightery::$configurations['Database'][$connection]['hostname'];
        $this->currentConnection['database'] = Brightery::$configurations['Database'][$connection]['database'];
        $this->currentConnection['username'] = Brightery::$configurations['Database'][$connection]['username'];
        $password = Brightery::$configurations['Database'][$connection]['password'];
        $this->currentConnection['driver'] = Brightery::$configurations['Database'][$connection]['driver'];
        $this->currentConnection['charset'] = Brightery::$configurations['Database'][$connection]['charset'];

        try {
            $this->db = new PDO($this->currentConnection['driver'] . ":host=" . $this->currentConnection['host'] . ";dbname=" . $this->currentConnection['database'] . ";charset=" . $this->currentConnection['charset'], $this->currentConnection['username'], $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->db;
        } catch (PDOException $e) {
            if ($replication)
                throw $e;
            else
                return false;
        }
    }

    public function select($value = NULL)
    {
        $this->select = $value;
        return $this;
    }

    public function limit($limit = null, $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function where($field = FALSE, $value = NULL, $special = '=')
    {
        if ($this->where && count($this->where))
            $this->where .= ' AND';
        else
            $this->where = ' WHERE';

        if (is_array($value)) {
            $this->where .= ' ' . ($field) . ' IN (\'' . implode('\',\'', $value) . '\')';
        } elseif ($value === NULL)
            $this->where .= ' ' . ($field);
        else {
            if (strpos($field, '=') or strpos($field, '<') or strpos($field, '>') or strpos($field, '!')) {
                $str = preg_match("(<=|>=|>|<|=)", $field, $equation_mark);
                $field = str_replace([' ', '<', '>', '=', '!'], '', $field);
                $this->where .= ' ' . $this->convert_dots(trim($field)) . ' ' . $equation_mark['0'] . ' ' . ($value);
            } else {
                if ($special != 'like')
                    $this->where .= ' ' . $this->convert_dots($field) . ' ' . $special . ' "' . ($value) . '"';
                else
                    $this->where .= ' ' . $this->convert_dots($field) . ' ' . $special . ' "%' . ($value) . '%"';
            }
        }
        return $this;
    }

    public function like($field = FALSE, $value = NULL)
    {
        $this->where($field, $value, 'like');
    }

    public function set($key = FALSE, $value = NULL)
    {
        $this->set[$key] = ($value);
        return $this;
    }

    public function get($table = FALSE)
    {
        $this->from = $this->convert_dots($table);
        return $this;
    }

    public function order_by($key, $order) {
        $this->orderBy .= $key .' ' . $order .' ';
    }
    public function join($table = FALSE, $on = FALSE, $type = 'INNER')
    {
        $type = strtoupper($type);
        switch ($type) {
            case 'INNER':
                $this->join .= ' INNER JOIN ';
                break;
            case 'LEFT':
                $this->join .= ' LEFT JOIN ';
                break;
            case 'RIGHT':
                $this->join .= ' RIGHT JOIN ';
                break;
        }
        $this->join .= $this->convert_dots($table) . ' ON ' . $on;
        return $this;
    }

    private function build_query($type = 'get')
    {
        if ($this->query)
            return;
        if ($type == 'get') {
            $this->query = 'SELECT ' . $this->select . ' FROM ' . $this->from . " " . $this->join;
        } elseif ($type == 'update') {
            $set = null;
            foreach ($this->set as $key => $value)
                $set[] = "`" . $key . "` = " . "'" . $this->escape($value) . "'";
            $set = implode(',', $set);
            $this->query = 'UPDATE ' . $this->from . " SET " . $set;

        } elseif ($type == 'insert') {
            foreach ($this->set as $key => $value) {
                $keys[] = $this->convert_dots($key);
                $values[] = "'" . $this->escape($value) . "'";
            }
            $keys = implode(',', $keys);
            $values = implode(',', $values);
            $this->query = 'INSERT INTO ' . $this->from . " (" . $keys . ") VALUES (" . $values . ")";
        } elseif ($type == 'delete') {
            $this->query = 'DELETE FROM ' . $this->from . " ";
        }

        if ($this->where)
            $this->query .= $this->where;

        if ($this->orderBy)
            $this->query .= ' ORDER BY ' . $this->orderBy;

        if ($this->limit)
            $this->query .= ' LIMIT ' . $this->offset . ', ' . $this->limit;

        $this->where = null;
        $this->select = "*";
        $this->from = null;
        $this->join = null;
        $this->set = null;
        $this->groupBy = null;
        $this->orderBy = null;
        $this->limit = null;
        $this->last_query = $this->query;
        if ($this->query)
            return $this->query;
    }

    public function query($query)
    {
        $this->query = $query;
        $this->query = str_replace(['select ', ' where ', ' limit ', ' group by '], ['SELECT ', ' WHERE ', ' LIMIT ', ' GROUP BY '], $this->query);
        return $this;
    }

    public function row()
    {
        $this->executed_query();
        $started = microtime(true);
        $res = $this->db->prepare($this->query);
        $res->execute();
        $executed = microtime(true);
        $this->query_queue[] = [
            'started' => $started,
            'executed' => $executed,
            'execution_time' => ($executed - $started),
            'query' => $this->query
        ];
        $this->query = null;
        return $res->fetch(PDO::FETCH_OBJ);
    }

    public function result()
    {
        $this->executed_query();
        $started = microtime(true);
        $res = $this->db->prepare($this->query);
        $res->execute();
        $executed = microtime(true);
        $this->query_queue[] = [
            'started' => $started,
            'executed' => $executed,
            'execution_time' => ($executed - $started),
            'query' => $this->query
        ];
        $this->query = null;
        return $res->fetchAll(PDO::FETCH_CLASS);
    }

    public function result_array()
    {
        $result = [];
        $this->executed_query();
        $started = microtime(true);
        $res = $this->db->prepare($this->query);
        $res->execute();
        $executed = microtime(true);
        $this->query_queue[] = [
            'started' => $started,
            'executed' => $executed,
            'execution_time' => ($executed - $started),
            'query' => $this->query
        ];
        $this->query = null;
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function executed_query()
    {
        $this->build_query();
        return htmlentities($this->query);
    }

    public function insert($table = FALSE, $data = false)
    {
        if ($data)
            $this->set = $data;
        $this->from = $this->convert_dots($table);
        $this->build_query('insert');
        $started = microtime(true);
        $exec = $this->db->exec($this->query);
        $executed = microtime(true);
        $this->query_queue[] = [
            'started' => $started,
            'executed' => $executed,
            'execution_time' => ($executed - $started),
            'query' => $this->query
        ];
        $this->query = null;
        return $exec;
    }

    public function insert_id()
    {
        return $this->db->lastInsertId();
    }

    public function update($table = FALSE, $data = false)
    {
        if ($data)
            $this->set = $data;
        $this->from = $this->convert_dots($table);
        $this->build_query('update');
        $started = microtime(true);
        $exec = $this->db->exec($this->query);
        $executed = microtime(true);
        $this->query_queue[] = [
            'started' => $started,
            'executed' => $executed,
            'execution_time' => ($executed - $started),
            'query' => $this->query
        ];
        $this->query = null;
        return $exec;
    }

    private function convert_dots($string)
    {
        if (!strpos($string, '.'))
            return '`' . $string . '`';
        $string = explode('.', $string);
        $count = count($string);
        $i = 0;
        $result = NULL;
        foreach ($string as $item) {
            $i++;
            $result .= '`' . $item . '`';
            if ($i < $count)
                $result .= '.';
        }
        return $result;
    }

    public function delete($table)
    {
        $this->from = $this->convert_dots($table);
        $this->build_query('delete');
        $started = microtime(true);
        $exec = $this->db->exec($this->query);
        $executed = microtime(true);
        $this->query_queue[] = [
            'started' => $started,
            'executed' => $executed,
            'execution_time' => ($executed - $started),
            'query' => $this->query
        ];
        $this->query = null;
        return $exec;
    }

    public function getLastQuery()
    {
        return $this->last_query;
    }

    public function getQueryLog()
    {
        return $this->query_queue;
    }

    public function getCurrentConnection()
    {
        return $this->currentConnection;
    }

    private function escape($string)
    {
        return str_replace(["'", '"'], ["\'", '\"'], $string);
    }
}
