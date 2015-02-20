<?php
ini_set('display_errors', 1);
$params = [
    "dbhostname" => "localhost",
    "dbname" => "elaugier_lapassiondespoemescom2pointzero",
    "dbusername" => "elaugier_njuyhbv",
    "dbpassword" => "q2VqXXDeYyw6V87m9d82",
];
require './AT/DB.php';
$db = new \AT\DB($params['dbhostname'],$params['dbname'],$params['dbusername'],$params['dbpassword']);

$result = $db->query("describe api_session");
var_dump($result);
