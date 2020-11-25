<?php
    function connect_to_sql() : mysqli
    {
        $conn = mysqli_connect("localhost", "root", "") or die("Wrong sql login data!");
        mysqli_query($conn, "SET NAMES UTF-8");
        mysqli_query($conn, "SET character_set_results=utf8");
        mysqli_set_charset($conn, "utf8");
        return $conn;
    }

    function close(mysqli $connection) : void
    {
        mysqli_close($connection);
    }