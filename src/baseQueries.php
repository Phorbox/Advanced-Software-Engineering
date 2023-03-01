<?php
include_once("dbInfo.php");
function insertQueryCSV($dblink,$table,$columni,$row)
{
    $columns = "";
    foreach ($columni as $value) {
        $columns = "$columns,`$value`";
    }
    $columns = trim($columns,",");
    
    $rows = "";
    foreach ($row as $value) {
        $insert = addSlashes($value);
        $rows = "$rows,'$insert'";
    }
    $rows = trim($rows,",");
    
    $sql = "INSERT INTO `$table` ($columns) VALUES ($rows)";
    $dblink->query($sql) or  
    die("Something went wrong with Query: $sql<br>\n".$dblink->error);
    
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

function insertQueryAssoc($dblink,$table,$assoc)
{
    $columns = "";
    $rows = "";
    
    foreach($assoc as $x => $x_value) {
        $insert = addSlashes($x_value);
        
        $columns = "$columns,`$x`";
        $rows = "$rows,`$insert`";
    }
    
    $columns = trim($columns,",");
    $rows = trim($rows,",");
    

    $sql = "INSERT INTO `$table` ($columns) VALUES ($rows)";
    $dblink->query($sql) or  
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    
}

function commit($dblink){
    if (!mysqli_commit($dblink )) {
        print("Transaction commit failed\n");
    }
}

function autoOff($dblink){
    $sql="Set autocommit=0;";
    $dblink->query($sql) or
        die("Something went wrong with <br>Query: $sql<br>\n" . $dblink->error);
}