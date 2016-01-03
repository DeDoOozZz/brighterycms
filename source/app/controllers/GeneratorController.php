<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Generator Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface none
 * @module Generator
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/generator
 * @controller GeneratorController
 *
 **/
class GeneratorController extends Brightery_Controller
{
    public function indexAction()
    {
        $generator = new GeneratorProcessor($this);
        $generator->startup();
    }
}

define('BASE_PATH', dirname(__FILE__));
define('author', '');
define('version', '1.0');
define('PATH_CDN', dirname(__FILE__) . "/cdn/");

class GeneratorProcessor
{
    protected $db;
    protected $inputStream;
    protected $controller;
    private $dataSet;
    private static $suggestions = array();

    function __construct($controller)
    {
        $this->controller = $controller;
        $this->db = Brightery::SuperInstance()->Database;
    }

    function startup()
    {
        while (1) {
            echo $this->colorize("Choose from options below:\n", 'blue') .
                $this->colorize("(1)", 'red') . $this->colorize(" Generate a Module\n", 'yellow') .
                $this->colorize("(2)", 'red') . $this->colorize(" Generate a Model\n", 'yellow');

//         (2)- CRUD \n
//         (3) models auto generator \n
//         (4)- generate language \n
//         (5)- generate module \n ";

            switch ($this->inputStream(array(1, 2))) {
                case 1:
                    $this->modulePreparation();
                    break;
                default:
                    echo $this->colorize("Please insert a valid option number or \"q\" to quit\n", 'red');
            }
        };
    }

    public function modulePreparation()
    {
        echo $this->colorize("Please insert module name: ", 'blue');
        $this->data('module_name', strtolower($this->inputStream()));
        $PATH = ROOT . '/source/app/modules/';
        //define model
        define('PATH_MODEL', $PATH . $this->data('module_name') . "/models/");
        //define controller
        define('PATH_CONTROLLER', $PATH . $this->data('module_name') . "/controllers/management/");
        //define view
        define('PATH_VIEW', $PATH . $this->data('module_name') . "/views/management/");
        //define language
        define('PATH_LANGUAGE', $PATH . $this->data('module_name') . "/languages/en/");
        //create module folder
        if (!file_exists(PATH_MODEL))
            @mkdir(PATH_MODEL, 0777, TRUE);
        //create controller folder
        if (!file_exists(PATH_CONTROLLER))
            @mkdir(PATH_CONTROLLER, 0777, TRUE);
        //create style folder
        if (!file_exists(PATH_VIEW))
            @mkdir(PATH_VIEW, 0777, TRUE);
        //create language folder
        if (!file_exists(PATH_LANGUAGE))
            @mkdir(PATH_LANGUAGE, 0777, TRUE);

        $i = 1;
        echo $this->colorize("Please insert tables\n
        (Nothing to process, q to quite, tab to complete table name): ", 'blue');

        do {
            echo $this->colorize("Table #$i: ", 'green');
            $suggestedTables = array();
            foreach ($this->db->query("SHOW TABLES")->result_array() as $k => $suggestedTable) {
                foreach ($suggestedTable as $kk => $t) ;
                $suggestedTables[] = $t;
            }
            $table = $this->inputStream($suggestedTables);
            if ($table != '') {
                if (!$this->db->query("SHOW TABLES LIKE '" . $table . "'")->row())
                    echo $this->colorize("Can't find this table \n", 'yellow');
                else {
                    $i++;
                    $tables[] = $table;
                }
            }
        } while ($table != '');

        for ($i = 0; $i < count($tables); $i++) {
            // CREATING MODULE FOR
            echo $this->colorize("CREATE MODULE FOR " . $tables[$i] . "  \n", 'blue');

            // MODEL
            if (!file_exists(PATH_MODEL . ucfirst($tables[$i]) . ".php")) {
                $this->generate_model($tables[$i], $this->data('module_name'));
            } else {
                echo $this->colorize("THE MODEL " . ucfirst($tables[$i]) . ".php ALREADY EXISTS AND IT'S STATUS IS : ", 'yellow');
                $this->check_model_status($tables[$i]);
            }

            // CONTROLLER
            if (!file_exists(PATH_CONTROLLER . ucfirst($tables[$i]) . ".php")) {
                $this->generate_controller($tables[$i]);
            } else {
                echo $this->colorize("THE CONTROLLER " . ucfirst($tables[$i]) . ".php ALREADY EXISTS ", 'yellow');
            }

            // VIEW
            if (!file_exists(PATH_VIEW . ucfirst($tables[$i]) . ".php")) {
                $this->generate_view($tables[$i]);
            } else {
                echo $this->colorize("THE VIEW " . ucfirst($tables[$i]) . ".php ALREADY EXISTS ", 'yellow');
            }

            // LANGUAGE
            if (!file_exists(PATH_LANGUAGE . ucfirst($tables[$i]) . ".php")) {
                $this->generate_language($tables[$i]);
            } else {
                echo $this->colorize("THE VIEW " . ucfirst($tables[$i]) . ".php ALREADY EXISTS ", 'yellow');
            }
        }
    }

    public function generate_model($tablename, $moduleName = "")
    {

        $select = "SHOW COLUMNS FROM `$tablename`";
        $sel = $this->db->query($select)->result();
        $captalizeFirstLetter = ucfirst($tablename);
        $lowersFirstLetter = strtolower($tablename);
        $txt = "<?php
namespace modules\\$moduleName\models;            
defined('ROOT') OR exit('No direct script access allowed');
/**
 * @package Brightery CMS
 * @author " . author .
            "\n* @version " . version .
            "\n* @module $captalizeFirstLetter
 * @category general
 * @module_version " . version .
            "\n
 * @link http://store.brightery.com/module/general/$captalizeFirstLetter
 * @model Settings
 **/

class  $captalizeFirstLetter extends \Model { \n";
        $txt .= "\t";
        $txt .= 'public $_table =';
        $txt .= "'$lowersFirstLetter';"
            . "  \n \t public ";
        $txt .= '$_fields = array( ' . "\n";
        $txtfileds = "";
        $txtrule = "";
        foreach ($sel as $item) {
            $filed = $item->Field;
            if ($filed != 'language_id' && $filed != 'created')
                $checkfileds = $item->Field;

            $txt .= "\t '$filed' => ";
            $valtype = $item->Type;
            preg_match_all("/([a-z]+)\(?([a-zA-Z0-9',]+)?\)?/", "$valtype", $matches);
            $type = $matches[1][0];
            $val = $matches[2][0];
            $key = $item->Key;
            $txt .= " array('$type'";
            if (!empty($val) && is_numeric($val))
                $txt .= ",$val";
            else if (!empty($val) && !is_numeric($val))
                $txt .= ",[$val]";

            if (!empty($item->Key))
                $txt .= ",'$key'), \n";
            else
                $txt .= "), \n";
            if ($key != 'PRI') {
                if ($filed == 'image') {
                    $txtrule .= "'image' => array('required'),\n";
                    $txtruleimg = "\t 'add' => array(
                'image' => array('file' => array(
                    array(
                        'upload_path' => \"./cdn/$tablename\",
                        'allowed_types' => \"gif|jpg|png|jpeg|pdf\",
                       'required' => TRUE
                    )
                )), \n ) \n,
                'edit' => array(
                'image' => array('file' => array(
                        array(
                            'upload_path' =>  \"./cdn/$tablename\",
                            'allowed_types' => \"gif|jpg|png|jpeg|pdf\",
                            'required' => FALSE
                        )
                    )),
                ";
                } elseif ($filed == 'file')
                    $txtrule .= "\t '$filed' => array('file' => array(
                    array(
                       'upload_path' => \"./cdn/$tablename\",
                       'allowed_types' => \" \",
                       'required' => TRUE

                ) \n";
                elseif ($filed != 'language_id' && $filed != 'created') {
                    $txtrule .= " \t '$filed' => array('required'";

                    if ($type == 'int')
                        $txtrule .= ", 'numeric'), \n";
                    elseif ($type == 'datetime')
                        $txtrule .= ", 'datetime'), \n";
                    else
                        $txtrule .= "), \n";
                }
                $filedrep = str_replace("_", " ", $filed);
                $txtfileds .= "\t '$filed' =>'$filedrep', \n";
            }
        }
        $txt .= "\t);   \n \n \n";

        $txt .= "\tpublic function rules() {
        return array( \t
        'all' => array( \n";
        $txt .= $txtrule;

        $txt .= "\t ),";

        if ($checkfileds == 'file' || $checkfileds == 'image') {
            if (isset($txtruleimg))
                $txt .= $txtruleimg;
            $txt .= "\t) \n  );   \n \n \n";
        } else {
            if (isset($txtruleimg))
                $txt .= $txtruleimg . "\n )";
            $txt .= " \t);   \n \n \n";
        }
        $txt .= "} \n \n \n";

        $txt .= "\tpublic function fields() {
        return array( \n";

        $txt .= $txtfileds;

        $txt .= "\t);
    }
";

        $txt .= "} \n ";

        $myfile = fopen(PATH_MODEL . ucfirst($tablename) . '.php', "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function generate_controller($table)
    {
        $module = $this->data('module_name');
        $fields = array();
        $primary_key = null;
        $Controller = ucfirst($table);
        $controller = strtolower($table);

        $structure = $this->db->query("SHOW COLUMNS FROM $table")->result();
        foreach ($structure as $__item) {
            $fields[] = $__item->Field;
            if ($__item->Key == 'PRI')
                $primary_key = $__item->Field;
        }
        $this->data('fields', $fields);
        $select = implode(', ', $fields);


        $attributes = "array(";
        foreach ($fields as $f)
            if ($primary_key != $f)
                $attributes .= "'$f' => \$this->input->post('$f'),";
        $attributes .= ");";

        $language = null;
        if (in_array('language_id', $fields))
            $language = "\${$controller}->language_id = \$this->language->getDefaultLanguage();";


        $content = <<<CONTROLLER
<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * $Controller Controller
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module $module
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/$module
 * @controller {$Controller}Controller
 **/
class {$Controller}Controller extends Brightery_Controller
{
    //protected \$layout = 'default';

    public function __construct()
    {
        parent::__construct();
        \$this->language->load("$controller");
    }

    public function indexAction(\$offset = 0)
    {
        \$this->permission('index');
        \$this->load->library('pagination');
        \${$controller} = new \modules\\{$module}\models\\{$Controller}();
        $language
        \${$controller}->_select = "$select";
        \${$controller}->_limit = \$this->config->get('limit');
        \${$controller}->_offset = \$offset;

        return \$this->render('$controller/index', array(
            'items' => \${$controller}->get(),
            'pagination' => \$this->Pagination->generate(array(
                'url' => Uri_helper::url('management/{$controller}/index'),
                'total' => \${$controller}->get(TURE),
                'limit' => \${$controller}->_limit,
                'offset' => \${$controller}->_offset
                )
            )
        ));
    }

    public function manageAction(\$id = false) {
        \$this->permission('manage');
        \${$controller} = new \modules\\{$module}\models\\{$Controller}();
        if(\$_POST)
            \${$controller}->attributes = $attributes;
        if (\$id)
            \${$controller}->$primary_key = \$id;
        $language

        //\$users = Form_helper::queryToDropdown('users', 'user_id', 'title', null, 'WHERE status != "active"');

        if (\${$controller}->save())
            Uri_helper::redirect("management/{$controller}");
        else
            return \$this->render('{$controller}/manage', array(
                'item' => \$id ? \${$controller}->get() : null
            ));
    }

    public function deleteAction(\$id = false) {
        \$this->permission('delete');

        if (!\$id) {
            return Brightery::error404();
        }
        \${$controller} = new \modules\\{$module}\models\\{$Controller}();
        \${$controller}->$primary_key = \$id;
        if (\${$controller}->delete())
            Uri_helper::redirect("management/{$controller}");
    }
}
CONTROLLER;

        $file = fopen(PATH_CONTROLLER . $Controller . 'Controller.php', "w") or die("Unable to open file!");
        fwrite($file, $content);
        fclose($file);
    }

    public function generate_view($tablename)
    {
        if (!file_exists(PATH_VIEW . $tablename))
            mkdir(PATH_VIEW . $tablename, 0777, TRUE);

        //creat index file
        $this->generate_view_index($tablename);
        //creat mangment file
        $this->generate_view_manage($tablename);
    }

    private function getFieldType($type)
    {
        preg_match_all("/([a-z]+)\(?([a-zA-Z0-9',]+)?\)?/", $type, $matches);
        if (isset($matches[1][0]) && isset($matches[2][0])) {
            $obj = new stdClass();
            $obj->type = $matches[1][0];
            $obj->length = $matches[2][0];
            return $obj;
        } else
            return null;
    }

    public function check_model_status($table)
    {
        include PATH_MODEL . ucfirst($table) . '.php';
        $model = "\modules\\" . $this->data('module_name') . "\models\\" . ucfirst($table);
        $model = new $model;
        $status = 'VALID';
        $errors = array();
        $feilds_array = array();
        $datatype_array = array();
        foreach ($this->db->query("SHOW COLUMNS FROM `$table`")->result() as $item) {
            $field = $this->getFieldType($item->Type);
            $field_array[] = $item->Field;
            $datatype_array[$item->Field] = array($field->type, $field->length);
        }

        // ARRAY LENGTH COMPARISON
        if (count($field_array) != count($model->__fields)) {
            $status = 'INVALID';
            $errors[] = 'NON-MATCHED NUMBER OF FIELDS\n';
        }
        // FIELDS COMPARISON
        foreach ($field_array as $field) {
            if (!in_array($field, array_keys($model->__fields))) {
                $status = 'INVALID';
                $errors[] = 'THE FIELD ' . $field . " DOES NOT EXIST \n";
            }
        }
        echo $this->colorize($status . "\n", $status == 'VALID' ? 'yellow' : 'red');
        echo $this->colorize(implode('', $errors), 'red');
    }

    public function generate_language($tablename)
    {
        $sel = $this->db->query("SHOW COLUMNS FROM `$tablename`")->result();
        $tablenamecapital = ucwords(str_replace("_", " ", $tablename));
        $txt = "<?php
      return array( \n
               '$tablename' => \"$tablenamecapital\", \n";
        foreach ($sel as $item) {
            if ($item->Type != 'PRI' && $item->Field != 'language_id') {
                $filed = $item->Field;

                $filedrep = str_replace("_", " ", $filed);
                $filedrep = str_replace("status id", "", $filedrep);
                $filedupercase = ucwords($filedrep);
                $txt .= "\t\t'$filed' => \"$filedupercase\",\n";
            }
        }
        $txt .= "); \n";

        $myfile = fopen(PATH_LANGUAGE . $tablename . '.php', "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function generate_view_index($tablename)
    {
        $headtxt = "";
        $bodytxt = "";
        $txtIndex = "<div class=\"panel panel-default\">
    <div class=\"panel-heading\">
        <h3 class=\"panel-title\">{{ lang.$tablename }}</h3>

        <div class=\"panel-options\">
        <a href=\"{{ helper.uri.url('management/$tablename/manage') }}\" class=\"btn btn-secondary\" style=\"color: #FFF;\">
            {{ lang.add }}
        </a>
        </div>
    </div>
    <div class=\"panel-body\">

        <table class=\"table table-bordered table-striped\" id=\"datatable\">
            <thead>
            <tr>\n";

        $select = "SHOW COLUMNS FROM `$tablename`";
        $sel = $this->db->query($select)->result();
        $flag = 0;
        foreach ($sel as $item) {
            $filed = $item->Field;
            if ($item->Key != 'PRI' && $item->Field != 'language_id' && $item->Field != 'created') {
                $headtxt .= "<th>{{ lang.$filed }}</th>\n";
                if ($filed == 'image') {
                    $bodytxt .= " <td><img src=\"{{helper.uri.cdn()}}$tablename/{{item.image}}\" height=\"42\" width=\"42\"></td>";
                    if (!file_exists(PATH_CDN . $tablename))
                        mkdir(PATH_CDN . $tablename, 0777, TRUE);
                } else
                    $bodytxt .= "<td>{{ item.$filed }}</td>\n";
            } elseif ($item->Key == 'PRI')
                $prikey = $item->Field;


            if ($item->Key != 'DATE ')
                $flag = 1;
        }
        $txtIndex .= $headtxt . "<th class=\"no-sorting\">{{ lang.operations }}</th>
           </tr>
            </thead>
            <tbody class=\"middle-align\">

            {% for item in items %}
                <tr>
";
        $txtIndex .= $bodytxt;
        $txtIndex .= "
            <td>
                <a class=\"btn btn-info btn-sm\" href=\"{{ helper.uri.url('management/$tablename/manage', item.$prikey ) }}\">{{lang.edit}}</a>
                <a href=\"#\" class=\"btn btn-secondary btn-sm delete_msg\"  data-url_id=\"{{ helper.uri.url('management/$tablename/delete' , item.$prikey)}}\" data-toggle=\"modal\" data-target=\"#deleteMsg\" style=\"color:#fff;\">{{lang.delete}}</a>
            </td>
           </tr>
          {% endfor %}
            </tbody>
        </table>

    </div>
</div>
<div class=\"modal fade\" id=\"deleteMsg\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                <h4 class=\"modal-title\" id=\"myModalLabel\">{{lang.system_msg}}</h4>
            </div>
            <div class=\"modal-body\">
                <a>{{lang.delete_item}}</a>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-white\" data-dismiss=\"modal\">{{ lang.no }}</button>
                <a id=\"delete_id\" class=\"btn btn-danger\" href=\"url\">{{lang.delete}}</a>
            </div>
        </div>
    </div>
</div>
";
// if ($flag == 1) $txtIndex .= "<script type=\"text/javascript\">
//    jQuery(document).ready(function ($) {
//        $(\"#datatable\").dataTable();
//    });
//</script>
//";

        $myfile = fopen(PATH_VIEW . $tablename . "\\" . 'index.twig', "w") or die("Unable to open file!");
        fwrite($myfile, $txtIndex);
        fclose($myfile);
    }

    public function generate_view_manage($tablename)
    {
        $flag = 0;
        $tablenameLowerCase = strtolower($tablename);
        $txtIndex = "<div class=\"panel panel-default\">
   <div class=\"panel-heading\">
       <h3 class=\"panel-title\">{{ lang.$tablename }}</h3>
   </div>
   <div class=\"panel-body\">
       {{ helper.form.open(null,false,true,'role=\"form\" id=\"$tablenameLowerCase\" class=\"form-horizontal\"') }}
           {{ error }}";

        $select = "SHOW COLUMNS FROM `$tablename`";
        $sel = $this->db->query($select)->result();

        foreach ($sel as $item) {
            $filed = $item->Field;
            $key = $item->Key;
            if ($item->Key != 'PRI' && $item->Field != 'language_id' && $item->Field != 'created') {

                $txtIndex .= "<div class=\"form-group\">
               <label class=\"col-sm-2 control-label\" for=\"$filed\">{{ lang.$filed }}</label>
               <div class=\"col-sm-10\">
           ";
                if ($filed == 'image' || $filed == 'file')
                    $txtIndex .= "<input type=\"file\" class=\"form-control\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\">";
                elseif ($filed == 'password')
                    $txtIndex .= "<input type=\"password\" class=\"form-control\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\">";
                elseif ($filed == 'DATE') {
                    $txtIndex .= "<input type=\"text\" class=\"form-control datepicker validate[required]\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\"
                     value=\"{{ helper.form.value('from_date', item.$filed) }} \" data-format=\"D, dd MM yyyy\">
                        <div class=\"input-group-addon\">
                             <a href=\"#\"><i class=\"linecons-calendar\"></i></a>
                   ";
                    $flag = 1;
                } elseif ($key == 'INT' || $key == 'FLOAT' || $key == 'DOUBLE')
                    $txtIndex .= "<input type=\"number\" class=\"form-control validate[required, numeric]\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\"> \n";
                elseif ($key == 'text')
                    $txtIndex .= "<textarea  class=\"form-control validate[required]\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\"></textarea> \n";
                else
                    $txtIndex .= "<input type=\"text\" class=\"form-control validate[required]\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\"> \n";

                $txtIndex .= "</div>
           </div>
            <div class=\"form-group-separator\"></div>";
            }
        }

        $txtIndex .= " <div class=\"form-group\">
               <label class=\"col-sm-2 control-label\"></label>

               <div class=\"col-sm-10\">
                       <button type=\"submit\" class=\"btn btn-secondary\">{{ lang.submit }}</button>
               </div>
           </div>
        {{ helper.form.close() }}

    </div>
</div>";

        if ($flag == 1) {
            $txtIndex .= "<script src=\"{{ constant('STYLE_JS') }}/datepicker/bootstrap-datepicker.js\"></script>

<script type=\"text/javascript\">
    jQuery(document).ready(function ($) {
        $(\".datepicker\").datepicker();
    });
</script>";
        }

        $myfile = fopen(PATH_VIEW . $tablename . "\\" . 'manage.twig', "w") or die("Unable to open file!");
        fwrite($myfile, $txtIndex);
        fclose($myfile);
    }

    public function colorize($text, $status)
    {
        $out = "";
        switch ($status) {
            case "green":
                $out = "[0;32m"; //Green background
                break;
            case "red":
                $out = "[0;31m"; //Red background
                break;
            case "yellow":
                $out = "[0;33m"; //Yellow background
                break;
            case "blue":
                $out = "[0;34m"; //Blue background
                break;
            default:
                $out = "";
        }
//        return "\033" . "$out" . "$text" . "\033[0m";
        return $text;
    }

    public function inputStream($var = array())
    {
        self::$suggestions = $var;
        if (PHP_OS == 'WINNT') {
            $input = trim(stream_get_line(STDIN, 1024, PHP_EOL));
        } else {
            readline_completion_function(array('self', 'getSuggestions'));
            $input = trim(readline($this->inputStream));
        }

        if ($input) {
            if (in_array(strtolower($input), array('exit', 'quit', 'q'))) {
                echo $this->colorize("ABORTING ...\n", 'red');
                exit;
            } else
                return $input;
        }
    }

    public function data($key, $value = null)
    {
        if ($value !== null)
            $this->dataSet[$key] = $value;
        else
            return $this->dataSet[$key];
    }

    public static function getSuggestions()
    {
        return self::$suggestions;
    }

}
