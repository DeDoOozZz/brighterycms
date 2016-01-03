<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Pages Controller
 *
 * @package Brightery CMS
 * @author Fatma Ahmad <fatma.ahmad@brightery.com>
 * @version 1.0
 * @interface management
 * @module Generate
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/generate
 * @controller Generate
 *
 **/
class GenerateController extends Brightery_Controller
{
     public function indexAction()
     {
         $generator = new Generate;
         $generator->run();
     }
}





define('ROOT', TRUE);
define('BASE_PATH', dirname(__FILE__));
define('author', '');
define('version', '1.0');
define('PATH_CDN', dirname(__FILE__) . "/cdn/");

class Generate {

    protected $db;

    function __construct() {
        $this->db = Brightery::SuperInstance()->Database;
    }

//chose what you want to creat
    function run() {


        echo "Please choose (1,2,3,4,5) \n 1- model \n 2- CRUD \n 3- models auto generator \n 4- generate language \n 5- generate module \n ";
        $hadelchoose = fopen("php://stdin", "r");
        $firstchoose = fgets($hadelchoose);
//echo PATH_MODEL." \n".PATH_CONTROLLER." \n".PATH_VIEW." \n".PATH_FOLDER_VIEW." \n".PATH_LANGUAGE;
        switch (trim($firstchoose)) {
            case 1:
                //define model
                $PATH=str_replace("\source\app\controllers","\source\app\models\\",dirname(__FILE__));
       
                define('PATH_MODEL', $PATH);

                echo "Please enter the table name ";
                $handle = fopen("php://stdin", "r");
                $line = fgets($handle);
                if (!(trim($line))) {
                    echo "ABORTING!\n";
                    exit;
                }

                $table = trim($line);
                $select="SHOW TABLES LIKE '" . $table . "'";
                $sel =  $this->db->query($select)->result();
               
                if (count($sel) == 1) {
                    if (!file_exists(PATH_MODEL . ucfirst(trim($line)) . ".php"))
                        $this->generate_model(trim($line));
                    else {
                        echo "Model " . ucfirst(trim($line)) . " found \n";
                        $this->check_fileds(strtolower(trim($line)));
                    }
                } else
                    echo 'Not found table';
                break;
            case 2:
            $PATH=str_replace("\source\app\controllers","\source\app\\",dirname(__FILE__));
            $PATHLang=str_replace("\source\app\controllers","\language\\english\\",dirname(__FILE__));
            $PATHView=str_replace("\source\app\controllers","\styles\management\default\layout\\",dirname(__FILE__));
                //define model
                define('PATH_MODEL', $PATH. "\models\\");

                //define controller

                define('PATH_CONTROLLER', $PATH. "\source\app\controllers\management\\");

                //define view

                define('PATH_VIEW',$PATHView);

                //define language

                define('PATH_LANGUAGE', $PATHLang );


                echo "Please enter table name ";
                $handle = fopen("php://stdin", "r");
                $line = fgets($handle);
                if (!(trim($line))) {
                    echo "ABORTING!\n";
                    exit;
                }
                $table = trim($line);
                
                $select="SHOW TABLES LIKE '" . $table . "'";
                $sel =  $this->db->query($select)->result();
               
                if (count($sel) == 1) {
                    if (!file_exists(PATH_MODEL . ucfirst(trim($line)) . ".php"))
                        $this->generate_model(trim($line));
                    else {
                        echo "Model " . ucfirst(trim($line)) . " found \n";
                        $this->check_fileds(strtolower(trim($line)));
                    }
                    if (!file_exists(PATH_VIEW . "\\$tablename\\"))
                        mkdir(PATH_VIEW . "\\$tablename\\", 0777, true);

                    $this->generate_control(strtolower(trim($line)));
                    $this->generate_view(strtolower(trim($line)));
                    $this->generate_language(strtolower(trim($line)));
                } else
                    echo 'Not found table';

                break;
            case 3:

                //define model
               $PATH=str_replace("\source\app\controllers","\source\app\models\\",dirname(__FILE__));
       
                define('PATH_MODEL', $PATH);

                echo "Please enter the database name ";
                $handle = fopen("php://stdin", "r");
                $line = fgets($handle);
                if (!(trim($line))) {
                    echo "ABORTING!\n";
                    exit;
                }

                $dbname = strtolower(trim($line));
                $sql = "SHOW TABLES FROM $dbname";
                $sel =  $this->db->query($sql)->result();
               
                foreach  ($sel as $row) {
                   
                    if (!file_exists(PATH_MODEL . ucfirst(trim($row->Tables_in_brighterycmsdemo)) . ".php"))
                        $this->generate_model(trim($row->Tables_in_brighterycmsdemo));
                    else {
                        echo "Model " . ucfirst(trim($line)) . " found \n";
                        $this->check_fileds(strtolower(trim($line)));
                    }
                }
                break;

            case 4:


                //define language
               $PATH=str_replace("\source\app\controllers","\language\\english\\",dirname(__FILE__));
       

                define('PATH_LANGUAGE', $PATH);


                echo "Please enter the table name ";
                $handle = fopen("php://stdin", "r");
                $line = fgets($handle);
                if (!(trim($line))) {
                    echo "ABORTING!\n";
                    exit;
                }
                $table = trim($line);
               $select="SHOW TABLES LIKE '" . $table . "'";
                $sel =  $this->db->query($select)->result();
               
                if (count($sel) == 1) 
                $this->generate_language(strtolower(trim($line)));
                else
                    echo 'Not found table';
                break;

            case 5:

                echo "Please enter the Module name ";
                $handle = fopen("php://stdin", "r");
                $lineModule = trim(fgets($handle));
                if (!(trim($lineModule))) {
                    echo "ABORTING!\n";
                    exit;
                }
                $lineModule = trim($lineModule);
                $PATH=str_replace("\source\app\controllers","\\source\app\modules\\",dirname(__FILE__));
                
          //define model
                define('PATH_MODEL', $PATH. "$lineModule\models\\");

                //define controller

                define('PATH_CONTROLLER',  $PATH. "$lineModule\controllers\management\\");

                //define view

                define('PATH_VIEW', $PATH. "$lineModule\\views\management\\");

                //define language

                define('PATH_LANGUAGE', $PATH. "$lineModule\languages\\english\\");
                //create module folder

                if (!file_exists(PATH_MODEL))
                    mkdir(PATH_MODEL, 0777, TRUE);
                //create controller folder
                if (!file_exists(PATH_CONTROLLER))
                    mkdir(PATH_CONTROLLER, 0777, TRUE);
                //create style folder
                if (!file_exists(PATH_VIEW))
                    mkdir(PATH_VIEW, 0777, TRUE);
                //create language folder
                if (!file_exists(PATH_LANGUAGE))
                    mkdir(PATH_LANGUAGE, 0777, TRUE);


                do {

                    echo "Please enter table name or E to exit \n";
                    $handle = fopen("php://stdin", "r");
                    $line = fgets($handle);
                    $tablesname[] = trim($line);
                    if (!(trim($line))) {
                        echo "ABORTING!\n";
                        exit;
                    }
                } while (trim($line) != 'E');

                for ($i = 0; $i < (count($tablesname) - 1); $i++) {

                    $table = trim($tablesname[$i]);
                   $select="SHOW TABLES LIKE '" . $table . "'";
                $sel =  $this->db->query($select)->result();
               
                if (count($sel) == 1) {
                        if (!file_exists(PATH_MODEL . ucfirst($tablesname[$i]) . ".php"))
                            $this->generate_model(trim($tablesname[$i]), $lineModule);
                        else {
                            echo "Model " . ucfirst(trim($tablesname[$i])) . " found \n";
                            $this->check_fileds(strtolower(trim($tablesname[$i])));
                        }

                        $this->generate_control(strtolower(trim($tablesname[$i])) , $lineModule);
                        $this->generate_view(strtolower(trim($tablesname[$i])));
                        $this->generate_language(strtolower(trim($tablesname[$i])));
                    } else
                        echo 'table not found : ' . $tablesname[$i];
                }
                break;
        }
    }

//generate model
    public function generate_model($tablename, $moduleName="") {

        $select = "SHOW COLUMNS FROM `$tablename`";
        $sel =  $this->db->query($select)->result();
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
                    $txtrule.="'image' => array('required'),\n";
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
                $txt.=$txtruleimg;
            $txt .= "\t) \n  );   \n \n \n";
        }
        else {
            if (isset($txtruleimg))
                $txt.=$txtruleimg . "\n )";
            $txt .= " \t);   \n \n \n";
        }
        $txt.="} \n \n \n";

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

//generate controller

    public function generate_control($tablename, $lineModule="") {
        $firstCapitalLetter = ucfirst($tablename);
        $className = ucfirst($tablename) . 'Controller';
        $select = "SHOW COLUMNS FROM `$tablename`";
        $sel = $this->db->query($select)->result();

        $txt = "<?php
defined('ROOT') OR exit('No direct script access allowed');
/**
 * $firstCapitalLetter Controller
 * @package Brightery CMS
 * @author " . author .
            "\n* @version " . version .
            "\n
 * @interface management
 * @module $firstCapitalLetter
 * @category general
 * @module_version  " . version .
            "\n
 * @link http://store.brightery.com/module/general/$firstCapitalLetter
 * @controller $firstCapitalLetter
 **/ \n class $className extends Brightery_Controller
         { \n";
        $txt .= 'protected $interface = \'management\';' . "\n";
        $txt .= 'protected $layout = \'full\';' . "\n";
        $txt.='protected $auth = true;' . "\n";
        //begin class
        // indexAction function
        // ModuleName
        $txt .= "\tpublic function indexAction()
         { \n";
        $txt.='$this->permission(\'index\');' . "\n";
        $txt .= '    $this->language->load("' . $tablename . '");';
        $txt .= "\n";
        $txt .= '$model = new \modules\\'.$lineModule.'\models\\'.ucfirst($tablename) . '();';
        $txt .= "\n";
        $txt .= ' $model->_select = "';
        $txtselectstring = "";
        $modelposttxt = "";
        foreach ($sel as $item) {
            $filed =$item->Field;
            $txtselectstring .= $filed . ",";
            if ($item->Key == 'PRI') {
                $primaryfiles = '$model->' . $item->Field . ' = $id;';
                $primaynamefiled = $item->Field;
            } else {
                $filedNamemodel = $item->Field;
                $modelposttxt .= "'" . $item->Field . "' => \$this->input->post('$filedNamemodel'), \n \t";

//                if(strpos($get['Field'], "_id") !== FALSE )
//                {
//                    $nameFiled=$get['Field'];
//                    $selectTableName="SELECT COLUMN_NAME, TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = '$nameFiled' AND `Key_name` = 'PRIMARY'";
//                    $selTableNmaeExcute= mysql_query($selectTableName);
//                    $getTableName= mysql_fetch_assoc($selTableNmaeExcute);
//
//                $sqltables = "SHOW TABLES FROM brighterycmsdemo";
//                $resulttables = mysql_query($sqltables);
//                while ($rowtables = mysql_fetch_row($resulttables)) {
//
//                  $result = mysql_query("SHOW COLUMNS FROM `table` LIKE '$nameFiled'");
//                  $exists = (mysql_num_rows($result))?TRUE:FALSE;
//                    if($exists) {
//                       // do your stuff
//                    }
//                }
                // echo $getTableName['TABLE_NAME'];
                // }
            }
            if ($item->Field == "created")
                $txtcreated = 'if (!$id)
                    $model->created = date("Y-m-d H:i:s");';
        }
        $txt .= rtrim($txtselectstring, ",");
        $txt .= '";';
        $txt .= "\n";
        $txt .= 'return $this->render(';
        $txt .= "'$tablename/index', array( \n \t 'items' => ";
        $txt .= '$model->get()
        ));';
        $txt .= "\n";
        $txt .= "} \n \n";
//new \modules\\'.ModuleName.'\models\\'.ucfirst($tablename) .
        // manageAction function
        $txt .= "public function manageAction(" . '$id' . " = false)
    {
        \$this->permission('manage');

        " . '$this' . "->language->load(\"$tablename\");
        if(\$id)
        " . '$model' . " = new \modules\\".$lineModule.'\models\\'. ucfirst($tablename) . "('edit');
        else
         " . '$model' . " = new \modules\\".$lineModule.'\models\\'. ucfirst($tablename) ."('add');
       \$model->attributes= \$this->Input->post();

        " . '$model' . "->language_id = " . '$this' . "->language->getDefaultLanguage(); \n";
        if (isset($txtcreated))
            $txt.="\n" . $txtcreated . "\n";
        $txt .=" if (" . '$id' . ")
        " . '$model' . "->$primaynamefiled = " . '$id' . ";

        if (" . '$model' . "->save()) {
            Uri_helper::redirect(\"management/$tablename\");
        }
        return " . '$this' . "->render('$tablename/manage', array(
            'item' => " . '$model' . "->get()
        ));
    }
    \n \n";

        // deleteAction function
        $txt .= ' public function deleteAction($id=false){
            $this->permission(\'delete\');
    ' . " \n";
        $txt .= ' if (!$id){
            Brightery::error404("The page you requested is not found.");
            }
        $model = new \modules\\'.$lineModule.'\models\\'. ucfirst($tablename) . '();';
        $txt .= $primaryfiles . " \n";
        $txt .= ' if ($model->delete())
            Uri_helper::redirect("management/' . $tablename . '");
    }';
        $txt .= " \n } \n "; //end class
        $myfile = fopen(PATH_CONTROLLER . ucfirst($tablename) . 'Controller.php', "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
    }

//generate views
    public function generate_view($tablename) {
        if (!file_exists(PATH_VIEW . $tablename))
            mkdir(PATH_VIEW . $tablename, 0777, TRUE);

        //creat index file
        $this->generate_view_index($tablename);
        //creat mangment file
        $this->generate_view_manage($tablename);
    }

//check fileds in model
    public function check_fileds($tablename) {

        include PATH_MODEL . ucfirst($tablename) . '.php';
        $select = "SHOW COLUMNS FROM `$tablename`";
        $sel = $this->db->query($select)->result();

        foreach ($sel as $item) {
            $filed = $item->Field;
            $txt = "";
            $valtype = $item->Type;
            preg_match_all("/([a-z]+)\(?([a-zA-Z0-9',]+)?\)?/", "$valtype", $matches);
            $type = $matches[1][0];
            $val = $matches[2][0];
            $key = $item->Key;
            $txt .= " ['$type'";
            if (!empty($val))
                $txt .= ",$val";
            if (!empty($item->Type))
                $txt .= ",'$key'";


            $check_arr_valus[] = $txt . "), ";
            $check_arr_keys[] = $filed;
        }
        $classname = ucfirst($tablename);
        $varclass = new $classname;
        $keys = array_keys($varclass->_fields);
        $valus = array_values($varclass->_fields);

        for ($i = 0; $i < count($check_arr_keys); $i++) {
            if (in_array($check_arr_keys[$i], $keys)) {
                $pos = array_search($check_arr_keys[$i], $keys);

                if ($valus[$pos] != $check_arr_valus[$i])
                    $check_arr_keys[$i] . ' : ' . ' not match' . "\n";
            } else
                echo $check_arr_keys[$i] . ' : ' . ' not found' . "\n";
        }
    }

//generate language

    public function generate_language($tablename) {
        $select = "SHOW COLUMNS FROM `$tablename`";
        $sel = $this->db->query($select)->result();
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

    // generate views index

    public function generate_view_index($tablename) {
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
                    $bodytxt .=" <td><img src=\"{{helper.uri.cdn()}}$tablename/{{item.image}}\" height=\"42\" width=\"42\"></td>";
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

    public function generate_view_manage($tablename) {
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

                $txtIndex.="<div class=\"form-group\">
               <label class=\"col-sm-2 control-label\" for=\"$filed\">{{ lang.$filed }}</label>
               <div class=\"col-sm-10\">
           ";
                if ($filed == 'image' || $filed == 'file')
                    $txtIndex.="<input type=\"file\" class=\"form-control\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\">";
                elseif ($filed == 'password')
                    $txtIndex.="<input type=\"password\" class=\"form-control\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\">";
                elseif ($filed == 'DATE') {
                    $txtIndex.="<input type=\"text\" class=\"form-control datepicker validate[required]\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\"
                     value=\"{{ helper.form.value('from_date', item.$filed) }} \" data-format=\"D, dd MM yyyy\">
                        <div class=\"input-group-addon\">
                             <a href=\"#\"><i class=\"linecons-calendar\"></i></a>
                   ";
                    $flag = 1;
                } elseif ($key == 'INT' || $key == 'FLOAT' || $key == 'DOUBLE')
                    $txtIndex.="<input type=\"number\" class=\"form-control validate[required, numeric]\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\"> \n";
                elseif ($key == 'text')
                    $txtIndex.="<textarea  class=\"form-control validate[required]\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\"></textarea> \n";
                else
                    $txtIndex.="<input type=\"text\" class=\"form-control validate[required]\" id=\"$filed\" placeholder=\"{{ lang.$filed }}\" name=\"$filed\" value=\"{{ helper.form.value('$filed', item.$filed) }}\"> \n";

                $txtIndex.="</div>
           </div>
            <div class=\"form-group-separator\"></div>";
            }
        }

        $txtIndex.=" <div class=\"form-group\">
               <label class=\"col-sm-2 control-label\"></label>

               <div class=\"col-sm-10\">
                       <button type=\"submit\" class=\"btn btn-secondary\">{{ lang.submit }}</button>
               </div>
           </div>
        {{ helper.form.close() }}

    </div>
</div>
<script>
    jQuery(document).ready(function () {
        // binds form submission and fields to the validation engine
        jQuery(\"#$tablenameLowerCase\").validationEngine(
                'attach', {
                    showOneMessage: true
                });
    });
</script>
";

        if ($flag == 1) {
            $txtIndex.="<script src=\"{{ constant('STYLE_JS') }}/datepicker/bootstrap-datepicker.js\"></script>

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

}