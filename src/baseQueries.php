<?php
include_once("dbInfo.php");
function insertQueryCSV($dblink,$table,$columni,$row)
{
    $columns = "";
    foreach ($columni as $value) {
        $mid = addslashes($value);
        $columns = "$columns,`$mid`";
    }
    trim($columns,",");
    
    $rows = "";
    foreach ($row as $value) {
        $mid = addslashes($value);
        $rows = "$rows,'$mid'";
    }
    trim($rows,",");
    

    $sql = "INSERT IGNORE INTO `$table` ($columns) VALUES ($rows)";
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

function insertQueryAssoc($dblink,$table,$assoc)
{
    $columns = "";
    $rows = "";

    foreach($assoc as $x => $x_value) {
        $columns = "$columns,`$x`";
        $mid = addslashes($x_value);
        $rows = "$rows,`$mid`";
    }
    
    $columns = trim($columns,",");
    $rows = trim($rows,",");
    

    $sql = "INSERT IGNORE INTO `$table` ($columns) VALUES ($rows)";
    $dblink->query($sql) or  
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    
}

function commit($dblink){
    $sql="Commit;";
    $dblink->query($sql) or
        die("Something went wrong with <br>Query: $sql<br>\n" . $dblink->error);
}

function autoOff($dblink){
    $sql="Set autocommit=0;";
    $dblink->query($sql) or
        die("Something went wrong with <br>Query: $sql<br>\n" . $dblink->error);
}