<?php
include_once("timer.php");
include_once("baseQueries.php");
function import($fname)
{
    importN($fname, 0);
}
function importN($fname, $rown)
{
    $dblink = db_connect("main");
    $table = "equipment_source";

    $fp = fopen($fname, "r");
    $count = 0;
    $time_startAll = tStart();
    $time_start = tStart();

    autoOff($dblink);
    $lastCount = 0;
    $columni = ['type', 'brand', 'serial'];
    $commitRows = 100;
    while (($row = fgetcsv($fp)) !== FALSE) {
        if (($count < $rown) or (count($row) != 3)) {
            $count++;
            if ($count % 1000 == 0) {
                echo "$fname row $count\n";
            }
            continue;
        }

        insertQueryCSV($dblink, $table, $columni, $row);
        $count++;
        if ($count % $commitRows == 0) {


            logTime($dblink, $table, $time_start, $count - $lastCount, "INSERT");

            $lastCount = $count;
            $time_start = tStart();
            commit($dblink);

            echo ("writing " . ($count - $commitRows) . " to " . ($count) . "\n");
        }
    }


    logTime($dblink, $table, $time_start, $count, "INSERT");
    commit($dblink);

    logTime($dblink, $table, $time_startAll, $count, "INSERT");
    commit($dblink);

    fclose($fp);
    $dblink->close();
}
