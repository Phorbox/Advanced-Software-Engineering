<?php
include_once("includers/timer.php");
include_once("includers/baseQueries.php");

$dblink = db_connect("main");

$start = tStart();
$brands = getArray($dblink, "brands");
$count = count($brands);
$timing = reportTime($dblink, "brands", $start, $count, "listBrands");
echo "<div>";

echo "<form method='post' action='modify.php'>";
echo '<table style="float:left;">';
echo '<tr>';
echo "<td></td> <td>Seconds</td> <td>Rows</td> <td>Rows/second</td>"; 
echo '</tr>';
echo '<tr>';
echo "<td>Current</td><td>".round($timing['newTime'],3)." </td><td>$timing[newCount] </td><td>".round($timing['newAvg'],3)." </td>"; 
echo '</tr>';
echo '<tr>';
echo "<td>Overall</td><td>".round($timing['oldTime'],3)." </td><td>$timing[oldCount] </td><td>".round($timing['oldAvg'],3)." </td>"; 
echo '</tr>';
echo '<tr>';
echo "<td>ID</td>";
echo "<td>Brand Name</td>";
echo "<td></td>";
echo '<tr>';
foreach ($brands as $id => $brand) {
    echo '<tr>';
    echo "<td>$id</td>";
    echo "<td>$brand</td>";
    echo "<td><button type='submit' name='modifyBrand' value='$id'>Modify</button></td>";
    echo '</tr>';
}
echo '</table>';
echo '</form>';

$start = tStart();
$types = getArray($dblink, "types");
$count = count($types);
$timing = reportTime($dblink, "types", $start, $count, "listTypes");
echo "<form method='post' action='modify.php'>";
echo '<table style="float:left;">';
echo '<tr>';
echo "<td></td> <td>Seconds</td> <td>Rows</td> <td>Rows/second</td>"; 
echo '</tr>';
echo '<tr>';
echo "<td>Current</td><td>".round($timing['newTime'],3)." </td><td>$timing[newCount] </td><td>".round($timing['newAvg'],3)." </td>"; 
echo '</tr>';
echo '<tr>';
echo "<td>Overall</td><td>".round($timing['oldTime'],3)." </td><td>$timing[oldCount] </td><td>".round($timing['oldAvg'],3)." </td>"; 
echo '</tr>';
echo '<tr>';
echo "<td>ID</td>";
echo "<td>Type Name</td>";
echo "<td></td>";
echo '<tr>';
foreach ($types as $id => $type) {
    echo '<tr>';
    echo "<td>$id</td>";
    echo "<td>$type</td>";
    echo "<td><button type='submit' name='modifyType' value='$id'>Modify</button></td>";
    echo '</tr>';
}
echo '</table>';
echo '</form>';


$start = tStart();
$inactives = getInactiveArray($dblink);
$count = count($inactives);
$timing = reportTime($dblink, "inactives", $start, $count, "listInactives");

echo "<form method='post' action='modify.php'>";
echo '<table style="float:left;">';
echo '<tr>';
echo "<td></td> <td>Seconds</td> <td>Rows</td> <td>Rows/second</td>"; 
echo '</tr>';
echo '<tr>';
echo "<td>Current</td><td>".round($timing['newTime'],3)." </td><td>$timing[newCount] </td><td>".round($timing['newAvg'],3)." </td>"; 
echo '</tr>';
echo '<tr>';
echo "<td>Overall</td><td>".round($timing['oldTime'],3)." </td><td>$timing[oldCount] </td><td>".round($timing['oldAvg'],3)." </td>"; 
echo '</tr>';
echo '<tr>';
echo "<td>ID</td>";
echo "<td>Table</td>";
echo "<td>Key</td>";
echo "<td></td>";
echo '<tr>';
foreach ($inactives as $id => $inactive) {
    echo '<tr>';
    echo "<td>$id</td>";
    echo "<td>$inactive[table]</td>";
    echo "<td>$inactive[key]</td>";

    echo "<td><button type='submit' name='modifyInactive' value='$id'>Modify</button></td>";
    echo '</tr>';
}
echo '</table>';
echo '</form>';
echo '</div>';
