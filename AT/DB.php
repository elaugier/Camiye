<?php
/**
 * Created by PhpStorm.
 * User: ela
 * Date: 20/02/2015
 * Time: 22:50
 */

namespace AT;
use PDO;

class DB extends PDO {

    private static $instance;
    private $dbhostname = null;
    private $dbname = null;

    public function __construct($params){
        $this->dbhostname = $params['dbhostname'];
        $this->dbname = $params['dbname'];
        parent::__construct(
            "mysql:host=" . $params['dbhostname'] .
            ";dbname=" . $params['dbname'] . ";charset=UTF8",
            $params['dbusername'],
            $params['dbpassword']
        );
        self::$instance = $this;
    }

    public static function getInstance($params=null) {

        if(is_null(self::$instance)) {
            self::$instance = new DB($params);
        }
        return self::$instance;
    }

    public function getTables(){
        $SQL = "SHOW TABLES FROM " . self::$dbname ;
        $result = $this->query($SQL);
        $rr = [];
        while ($row = $result->fetch(PDO::FETCH_NUM )){
            $rr[] = $row[0];
        };
        return $rr;
    }
    public function getTableProperties($tablename){
        $SQL = "SHOW COLUMNS FROM " . $tablename ;
        $result = $this->query($SQL);
        $rr = [];
        while ($row = $result->fetch(PDO::FETCH_NUM )){
            $rr[] = $row[0];
        };
        return $rr;
    }

    public function CreateClasses(){
        $tables = $this->getTables();
        $strtoeval ="";
        if(__NAMESPACE__){
            $strtoeval = "namespace " . __NAMESPACE__ . ";\n";
        }
        $strtoeval .= "// Création à la volée des classes\n";
        foreach($tables as $table){
            $columns = $this->getTableProperties($table);
            $strtoeval .= "class " . $table . " extends ObjectBase {\n";
            $strtoeval .= "\tprivate \$dbtablename = \"" . $table . "\";\n";
            $updatestatement1 = "UPDATE FROM " . $table . " SET ";
            $insertstatement1 = "INSERT INTO " . $table . "(";
            $insertstatement2 = ") VALUES(";
            foreach($columns as $column){
                /**
                 * set attribute
                 */
                $strtoeval .= "\tprivate $" . $column . ";\n";
                /**
                 * set getter
                 */
                $strtoeval .= "\tpublic function get" . $column . "(){\n";
                $strtoeval .= "\t\t\$this->" .$column . ";\n";
                $strtoeval .= "\t}\n";
                /**
                 * prepare insert statement
                 */
                $insertstatement1 .= $column . ",";
                $insertstatement2 .= ":$column,";
                /**
                 * prepare update statement
                 */
                $updatestatement1 .= "$column = :$column, ";
            }
            /**
             * set insert statement
             */
            $strtoeval .= "\tprivate \$insertStatement = \"";
            $strtoeval .= substr($insertstatement1,0,strlen($insertstatement1)-1) .
                substr($insertstatement2,0,strlen($insertstatement2)-1). ")\";\n";
            /**
             * set update statement
             */
            $strtoeval .= "\tprivate \$updateStatement = \"";
            $strtoeval .= substr($updatestatement1,0,strlen($updatestatement1)-1). ")\";\n";
            /**
             * set end of class
             */
            $strtoeval .= "}\n";
        }
        print "<pre>" . $strtoeval . "</pre>";

        try{
            eval($strtoeval);
        }
        catch(\Exception $e){
            echo "error : " . $e->getMessage();
        }
        return true;
    }

}