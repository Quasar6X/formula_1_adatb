<?php
    function connect_to_sql() : mysqli
    {
        $conn = new mysqli("localhost", "root", "") or die("Wrong sql login data!");
        $conn->query("SET NAMES UTF-8");
        $conn->query("SET character_set_resutls=utf8");
        $conn->set_charset("utf8");
        if (!$conn->select_db("csapat_sport"))
        {
            $conn->close();
            die("Database cannot be reached");
        }
        return $conn;
    }