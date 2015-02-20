<?php
/**
 * Created by PhpStorm.
 * User: ela
 * Date: 20/02/2015
 * Time: 22:50
 */

namespace AT;


class DB {
    private static $connection;
    function __construct($hostname, $database, $user, $password)
    {
        $this::$connection = new \PDO(
            "mysql:host=" . $hostname . ";" .
            "dbname=" . $database . ";charset=UTF8",
            $user,
            $password);
    }
    public static function getInstance($hostname = null, $database = null, $user = null, $password = null)
    {
        if (!(self::$connection instanceof self)) {
            self::$connection = new self($hostname, $database, $user, $password);
        }
        return self::$connection;
    }
    public static function exec($sql)
    {
        return self::$connection->exec($sql);
    }
    public static function query($sql)
    {
        return self::$connection->query($sql);
    }
    public static function prepare($sql)
    {
        return self::prepare($sql);
    }
}