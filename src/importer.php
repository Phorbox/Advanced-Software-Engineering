<?php
include_once("timer.php");
include_once("baseQueries.php");
function import($fname)
{

    $dblink = db_connect("main");
    $table = "equipment_source";

    $fp = fopen($fname, "r");
    $count = 0;
    $time_start = tStart();
    autoOff($dblink);

    $columni = ['type', 'brand', 'serial'];

    while (($row = fgetcsv($fp)) !== FALSE) {
        insertQueryCSV($dblink, $table, $columni, $row);
        $count++;
        // if ($count % 5000 == 0) {
        //     commit($dblink);
        // }
    }

    commit($dblink);

    $seconds = tTotal($time_start);
    $execution_time = ($seconds) / 60;

    logTime($dblink, $table, $seconds, $count, "INSERT");
    commit($dblink);

    // echo "<P>Execution time: $execution_time minutes or $seconds seconds.</p>";
    // $rowsPerSecond = $count / $seconds;
    // echo "<P>Insert rate: $rowsPerSecond per second</p>";
    fclose($fp);
    $dblink -> close();
}
