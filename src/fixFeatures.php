<?php

include_once("timer.php");
include_once("baseQueries.php");


// */10 * * * * php /var/www/html/advanced-software-project/src/fixFeatures.php
function updater($tableQuality, $len)
{
    $dblink = db_connect("main");
    $table = $tableQuality . "s";

    $time_startAll = tStart();
    $time_start = tStart();
    autoOff($dblink);

    $sql = "SELECT * FROM $table";

    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);

    while ($row = mysqli_fetch_assoc($result)) {
        $sql = "UPDATE `equipment_production` SET `$tableQuality`=" . $row["id"] . " WHERE `$tableQuality` LIKE '%" . $row["name"] . "%' LIMIT $len;";
        echo ($sql . "\r\n");
        $dblink->query($sql) or
            die("Something went wrong with Query: $sql<br>\n" . $dblink->error);




        logTime($dblink, $table, $time_start, $len, "UPDATE");
        $time_start = tStart();
        commit($dblink);
    }


    logTime($dblink, $table, $time_startAll, $len * $result->num_rows, "UPDATE");
    commit($dblink);
    $dblink->close();
}
function updaterS($tableQuality, $len, $target)
{
    $dblink = db_connect("main");
    $table = $tableQuality . "s";

    $time_startAll = tStart();
    $time_start = tStart();
    autoOff($dblink);

    $sql = "SELECT * FROM $table WHERE `name` = '$target'";

    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);

    while ($row = mysqli_fetch_assoc($result)) {
        $sql = "UPDATE `equipment_production` SET `$tableQuality`=" . $row["id"] . " WHERE `$tableQuality` LIKE '%" . $row["name"] . "%' LIMIT $len;";
        echo ($sql . "\r\n");
        $dblink->query($sql) or
            die("Something went wrong with Query: $sql<br>\n" . $dblink->error);


        logTime($dblink, $table, $time_start, $len, "UPDATE");
        $time_start = tStart();
        commit($dblink);
    }


    logTime($dblink, $table, $time_startAll, $len * $result->num_rows, "UPDATE");
    commit($dblink);
    $dblink->close();
}

for ($i = 0; $i < 10; $i++) {
    updaterS('brand', 10000, 'Hyundai');
}
