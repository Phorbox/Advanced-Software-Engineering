<?php
include_once("dbConnect.php");
include_once("timer.php");

$dblink = db_connect("main");
$table = "equipment_source";

$fp = fopen("equipment.txt", "r");
$count = 0;
$time_start = tStart();


while (($row = fgetcsv($fp)) !== FALSE) {
    $sql = "Insert into `$table` (`type`,`brand`,`serial`) values ('$row[0]','$row[1]','$row[2]')";
    $dblink->query($sql) or
        die("Something went wrong with <br>Line : $count<br>Query: $sql<br>\n" . $dblink->error);
    if ($count % 50000 == 0) {
        $current_time = tTotal($time_start);
        echo ("<p>Finished line $count Time: $current_time<br></p>");
    }
    $count++;
}

$seconds = tTotal($time_start);
$execution_time = ($seconds) / 60;
echo "<P>Execution time: $execution_time minutes or $seconds seconds.</p>";
$rowsPerSecond = $count / $seconds;
echo "<P>Insert rate: $rowsPerSecond per second</p>";
fclose($fp);
