<?php

class DB
{

    protected static $_conn;
    public static $_rendata;

    public function connect($connection_info = CONNECTION_INFO)
    {
        try {

            $conn = new PDO($connection_info[0], $connection_info[1], $connection_info[2]);
            $conn->exec("set names utf8");
            $conn->query(SESSION_TIMEZONE);
            self::$_conn = $conn;

        } catch (Exception $e) {

            echo 'Unable to connect: ' . $e->getMessage();
        }
    }

    public static function select($query)
    {
        $stmt = self::$_conn->query($query);
        self::$_rendata = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($query, $return_data = false)
    {
        self::$_conn->exec($query);
        self::$_rendata = self::$_conn->lastInsertId();
    }

    public static function affect($query)
    {
        self::$_rendata = self::$_conn->exec($query);
    }

    public static function statement($query)
    {
        self::$_rendata = self::$_conn->query($query);
    }

    public static function countQuery($query)
    {
        $stmt = self::$_conn->query($query);
        self::$_rendata = $stmt->fetch(PDO::FETCH_NUM);
    }

}
