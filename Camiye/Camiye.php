<?php
/**
 * Created by PhpStorm.
 * User: ela
 * Date: 08/02/2015
 * Time: 13:35
 */

namespace Camiye;


class Camiye
{
    const DEFAULTENVIRONMENT = 'NONE';
    private $application_name;
    private $application_environment;
    private $pdo_database;
    private $pdo_hostname;
    private $pdo_username;
    private $pdo_password;
    protected $DB;

    function __construct($data=null)
    {
        if (isset($data['application_name'])) {
            $this->application_name = $data['application_name'];
        }
        else {
            $this->application_name = uniqid(__CLASS__ . '-',true);
        }
        if (isset($data['application_environment'])) {
            $this->application_environment = $data['application_environment'];
        }
        else {
            $this->application_environment = self::DEFAULTENVIRONMENT;
        }
    }

    public function getApplicationName(){
        return $this->application_name;
    }

    public function setApplicationName($name){
        $this->application_name = $name;
    }

    public function pdo_set($data)
    {
        if (isset($data['pdo_database'])) {
            $this->pdo_database = $data['pdo_database'];
        }
        if (isset($data['pdo_hostname'])) {
            $this->pdo_hostname = $data['pdo_hostname'];
        }
        if (isset($data['pdo_username'])) {
            $this->pdo_username = $data['pdo_username'];
        }
        if (isset($data['pdo_password'])) {
            $this->pdo_password = $data['pdo_password'];
        }
        try {
            $this->DB = new \PDO(
                'mysql:host=' . $this->pdo_hostname .
                ';dbname=' . $this->pdo_database,
                $this->pdo_username,
                $this->pdo_password);
        } catch (\PDOException $e) {
            echo $this->jsonerror($e->getMessage());
            return false;
        }
    }

    private function jsonerror($message)
    {
        return "{error : [ message = " . $message . ']}';
    }

    /**
     * PSR-0 autoloader
     */
    public static function autoload($className)
    {
        $thisClass = str_replace(__NAMESPACE__.'\\', '', __CLASS__);

        $baseDir = __DIR__;

        if (substr($baseDir, -strlen($thisClass)) === $thisClass) {
            $baseDir = substr($baseDir, 0, -strlen($thisClass));
        }

        $className = ltrim($className, '\\');
        $fileName  = $baseDir;
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($fileName)) {
            require $fileName;
        }
    }

    /**
     * Register PSR-0 autoloader
     */
    public static function registerAutoloader()
    {
        spl_autoload_register(__NAMESPACE__ . "\\". __CLASS__ . "::autoload");
    }
}
