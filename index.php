<?php
ini_set('display_errors', 1);
require_once './conf/AppConfig.php';
require_once './AT/DB.php';
require_once './AT/Member.php';
$db = new \AT\DB($params);
//$db->CreateClasses();

$member = new \AT\Member();
echo json_encode($member->get());


