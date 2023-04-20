<?php
include_once("includers/timer.php");
include_once("includers/baseQueries.php");
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
    $commitRows = 100;
    while (($row = fgetcsv($fp)) !== FALSE) {
        if(($count < $rown) or (count($row) != 3)){
            $count++;
            if($count % 1000 == 0){
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

            echo("writing ".($count-$commitRows)." to ".($count)."\n");
        }
    }


    logTime($dblink, $table, $time_start, $count, "INSERT");
    commit($dblink);

    logTime($dblink, $table, $TimeAllStart, $count, "INSERT");
    commit($dblink);

    fclose($fp);
    $dblink -> close();
}
