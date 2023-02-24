<?php

include_once("dbInfo.php");
function db_connect($db)
{
    $dbInfo = dbInfo();
    $hostname = $dbInfo['hostname'];
    $username = $dbInfo['username'];
    $password = $dbInfo['password'];
    $dblink = new mysqli($hostname, $username, $password, $db);
    if (mysqli_connect_errno()) {
        die("Error connecting to database: " . mysqli_connect_error());
    }
    return $dblink;
}
