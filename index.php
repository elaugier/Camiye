<?php
ini_set('display_errors', 1);
$params = [
    "dbhostname" => "localhost",
    "dbname" => "elaugier_lapassiondespoemescom2pointzero",
    "dbusername" => "elaugier_njuyhbv",
    "dbpassword" => "q2VqXXDeYyw6V87m9d82",
];

$db = new PDO("mysql:host=" . $params['dbhostname'] .
    ";dbname=" . $params['dbname'] . ";charset=UTF8",
    $params['dbusername'],
    $params['dbpassword']
);


foreach($db->query("show tables") as $row)
{
    print $row['id'];
}
