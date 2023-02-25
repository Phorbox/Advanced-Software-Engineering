<?php
function tStart()
{
    return microtime(true);
}

function tTotal($start)
{
    return microtime(true) - $start;
}

function logTime($dblink, $table,$seconds,$count,$type){

    $sql = "INSERT INTO `log`(`table`, `seconds`, `rows`, `type`) 
            VALUES ('$table','$seconds','$count','$type')";

    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);

}