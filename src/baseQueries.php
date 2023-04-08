<?php
include_once("dbInfo.php");
include_once("timer.php");
function insertQueryCSV($dblink, $table, $columni, $row)
{
    $columns = "";
    foreach ($columni as $value) {
        $columns = "$columns,`$value`";
    }
    $columns = trim($columns, ",");

    $rows = "";
    foreach ($row as $value) {
        $insert = addSlashes($value);
        $rows = "$rows,'$insert'";
    }
    $rows = trim($rows, ",");

    $sql = "INSERT INTO `$table` ($columns) VALUES ($rows)";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}

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

function insertQueryAssoc($dblink, $table, $assoc)
{
    $columns = "";
    $rows = "";

    foreach ($assoc as $x => $x_value) {
        $insert = addSlashes($x_value);

        $columns = "$columns,`$x`";
        $rows = "$rows,`$insert`";
    }

    $columns = trim($columns, ",");
    $rows = trim($rows, ",");


    $sql = "INSERT INTO `$table` ($columns) VALUES ($rows)";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}

function commit($dblink)
{
    if (!mysqli_commit($dblink)) {
        print("Transaction commit failed\n");
    }
}

function autoOff($dblink)
{
    $sql = "Set autocommit=0;";
    $dblink->query($sql) or
        die("Something went wrong with <br>Query: $sql<br>\n" . $dblink->error);
}

function getDropDown($dblink, $table)
{
    $time_start = tStart();
    $sql = "SELECT `name`,`id` from `$table`";

    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);

    logTime($dblink, $table, $time_start, $result->num_rows, "get$table");
    return $result;
}

function getArray($dblink, $table)
{
    $result = getDropDown($dblink, $table);
    // $returner = [];
    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
        $idi = $data['id'];
        $returner[$idi] = $data['name'];
    }
    // var_dump( $returner);
    return $returner;
}

function isGeneric($quality)
{
    return ($quality == 'all' or $quality == '');
}

function getEquipment($dblink, $brand, $type, $serial, $offset, $length)
{

    $brandSql = (isGeneric($brand))   ? "`brand` like '%%'"    : "`brand` = '$brand'";
    $typeSql =  (isGeneric($type))   ? "`type` like '%%'"     : "`type` = '$type'";
    $serialSql = (isGeneric($serial))   ? "`serial` like '%%'"   : "`serial` like '%$serial%'";

    $sql = "SELECT `id`,`brand`,`type`,`serial` from `equipment_production` where $brandSql and $typeSql and $serialSql LIMIT $offset,$length";
    // echo $sql."</br>";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);


    return $result;
}
