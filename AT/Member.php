<?php
/**
 * Created by PhpStorm.
 * User: ela
 * Date: 21/02/2015
 * Time: 19:37
 */

namespace AT;

use PDO;

class Member {

    private $db;

    function __construct(){
        $this->db = DB::getInstance();
    }
    function get(){
        $SQL = "SELECT * FROM api_member";
        $result = $this->db->query($SQL);
        $rows = array();
        while($r = $result->fetch(PDO::FETCH_ASSOC))
        { $rows[] = $r; }
        return $rows;
    }
}