<?php
// Class_CodyMySQL

class CodyMySQL
{
    protected $mysql;
    public $host;
    public $port;
    protected $user;
    private $pass;
    protected $database;

    function __construct($host = "127.0.0.1", $port = 3306, $user = "root", $pass = "12345678", $database = "database")
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;

        $this->mysql = new mysqli($host, $user, $pass, $database, $port);
        if (mysqli_connect_errno()) {
            return false;
        }
        $this->mysql->set_charset('utf-8');
        $this->mysql->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);
    }

    function query($sql)
    {
        return $this->mysql->query($sql);
    }

    function get($sql)
    {
        $res = $this->query($sql);
        if (!$res) {
            return false;
        }
        $ret = array();
        while ($row = $res->fetch_assoc()) {
            $ret[] = $row;
        }
        $res->close();
        return $ret;
    }

    function getrow($sql)
    {
        $res = $this->Query($sql);
        if (!$res) {
            return false;
        }
        $ret = $res->fetch_assoc();
        $res->close();
        return $ret;
    }

    function insert($data, $table)
    {
        $sql = "INSERT INTO `$table` (`";
        $sql .= implode("`,`", array_keys($data));
        $sql .= "`) VALUES ('";
        $sql .= implode("','", array_values($data));
        $sql .= "')";
        return $this->query($sql);
    }

    function update($data, $table, $where = "0")
    {
        $sql = "UPDATE `" . $table . "` SET ";
        foreach ($data as $key => $value) {
            $sql .= "`" . $key . "` = '" . $value . "',";
        }
        $sql = rtrim($sql, ',');
        $sql .= ' WHERE ' . $where;
        return $this->query($sql);
    }

    function close()
    {
        $this->mysql->close();
    }

    function __destruct()
    {
        $this->close();
    }
}
