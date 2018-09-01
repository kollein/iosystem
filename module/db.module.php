<?php

class DB
{

    protected static $_conn;
    public static $_rendata;

    public function connect($connection_info = CONNECTION_INFO)
    {
        if (count($connection_info) === 3) {

            $conn = new PDO($connection_info[0], $connection_info[1], $connection_info[2]);
            $conn->exec("set names utf8");
            $conn->query("SET SESSION time_zone = '+7:00'");
            self::$_conn = $conn;

        } else {
            echo 'Connection infomation is wrong!';
        }
    }

    public static function selectQuery($query)
    {
        self::$_rendata = array();
        $stmt = self::$_conn->query($query);
        self::$_rendata = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function insertQuery($query, $returndata = false)
    {
        $this->_conn->exec($query);
        $lastId = $this->_conn->lastInsertId();
        if ($returndata === true) {
            $this->_rendata = $lastId . "," . $col_value;
        } else {
            $this->_rendata = $lastId;
        }
    }

    public static function updateQuery($query)
    {
        $stmt = $this->_conn->query($query);
        $rowCount = $stmt->rowCount();
        $this->_rendata = $rowCount;
    }

    public static function affect($query)
    {
        $this->_rendata = $this->_conn->exec($query);
    }

    public static function statement($query)
    {
        $this->_rendata = $this->_conn->query($query);
    }

    public static function countQuery($query)
    {
        $this->_rendata = array();
        $stmt = $this->_conn->query($query);
        $this->_rendata = $stmt->fetch(PDO::FETCH_NUM);
    }

}
