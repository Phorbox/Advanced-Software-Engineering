<?php
include_once("timer.php");
include_once("baseQueries.php");
function import($fname)
{
    importN($fname,0);
}
function importN($fname,$rown)
{
    $dblink = db_connect("main");
    $table = "equipment_source";

    $fp = fopen($fname, "r");
    $count = 0;
    $TimeAllStart = tStart();
    $time_start = tStart();

    autoOff($dblink);
    $lastCount = 0;
    $columni = ['type', 'brand', 'serial'];
    $commitRows = 1000;
    while (($row = fgetcsv($fp)) !== FALSE) {
        if((count($row) != 3)){
            $count++;
            continue;
        }

        insertQueryCSV($dblink, $table, $columni, $row);
        $count++;
        if ($count % $commitRows == 0) {

            $seconds = tTotal($time_start);
            logTime($dblink, $table, $seconds, $count - $lastCount, "INSERT");

            $lastCount = $count;
            $time_start = tStart();
            commit($dblink);

            echo("writing ".($count-$commitRows)." to ".($count)."\n");

        }
    }

    $seconds = tTotal($time_start);
    logTime($dblink, $table, $seconds, $count, "INSERT");
    commit($dblink);

    $secondsAll = tTotal($TimeAllStart);
    logTime($dblink, $table, $secondsAll, $count, "INSERT");
    commit($dblink);

    fclose($fp);
    $dblink -> close();
}
