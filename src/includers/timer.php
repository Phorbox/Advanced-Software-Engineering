<?php
function tStart()
{
    return microtime(true);
}

function tTotal($start)
{
    return microtime(true) - $start;
}

function logTime($dblink, $table, $start, $count, $type)
{

    $seconds = tTotal($start);
    $sql = "INSERT INTO `log`(`table`, `seconds`, `rows`, `type`) 
            VALUES ('$table','$seconds','$count','$type')";


    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}

function reportTime($dblink, $table, $start, $count, $type)
{
    $seconds = tTotal($start);

    $old = getTime($dblink, $table, $type);

    logTime($dblink, $table, $start, $count, $type);


    $oldAvg = ($old["seconds"] == 0) ? 0 : $old["rows"] / $old["seconds"];

    $Avg = $count / $seconds;


    return array(
        "newTime" => "$seconds",
        "newCount" => "$count",
        "newAvg" => "$Avg",
        "oldTime" => "$old[seconds]",
        "oldCount" => "$old[rows]",
        "oldAvg" => "$oldAvg"
    );
}

function getTime($dblink, $table, $type)
{
    $sql = "SELECT avg(`seconds`) as 'seconds', avg(`rows`) as 'rows' from `log` where `type`='$type' and `table`='$table';";
    // echo $sql."</br>";
    $result =  $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    $returner =  $result->fetch_array(MYSQLI_ASSOC);
    return $returner;
}
