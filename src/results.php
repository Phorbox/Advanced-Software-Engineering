<?php
include_once("baseQueries.php");
include_once("timer.php");

$dblink = db_connect("main");
$table = "equipment_source";
$TimeAllStart = tStart();

$query = $_POST['brand'];

$wherei = ["`brand` = '$query'"];

$columni = ['type', 'serial'];

select($dblink,$table,$columni,$wherei);


echo '<table>';
echo '<tr><td>Type</td><td>Serial</td></tr>';
while ($data =  $result->fetch_array(MYSQLI_ASSOC)){
    echo "<tr><td>$data[type]</td><td>$data[serial]</td></tr>";
}
echo '</table>';

$secondsAll = tTotal($TimeAllStart);
logTime($dblink, $table, $secondsAll, $count, "SELECT");
$dblink -> close();