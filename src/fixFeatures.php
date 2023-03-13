<?php

include_once("timer.php");
include_once("baseQueries.php");



function updater($tableQuality)
{
    $dblink = db_connect("main");
    $table = $tableQuality . "s";

    $TimeAllStart = tStart();
    $time_start = tStart();
    autoOff($dblink);

    $sql = "SELECT * FROM $table";

    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);

    while ($row = mysqli_fetch_assoc($result)) {
        $sql = "UPDATE `equipment_production` SET `$tableQuality`=" . $row["id"] . " WHERE `$tableQuality` LIKE '%" . $row["name"] . "%' LIMIT 1000;";
        echo ($sql . "\r\n");
        $dblink->query($sql) or
            die("Something went wrong with Query: $sql<br>\n" . $dblink->error);



        $seconds = tTotal($time_start);
        logTime($dblink, $table, $seconds, 1000, "UPDATE");
        $time_start = tStart();
        commit($dblink);
    }

    $secondsAll = tTotal($TimeAllStart);
    logTime($dblink, $table, $secondsAll, 1000, "UPDATE");
    commit($dblink);
    $dblink->close();
}


updater('type');
updater('brand');
// select brands
// loop update brands limit 1000
