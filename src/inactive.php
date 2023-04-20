<?php
include_once("includers/timer.php");
include_once("includers/baseQueries.php");

$dblink = db_connect("main");
$brands = getArray($dblink, "brands");
$types = getArray($dblink, "types");
$inactives = getInactiveArray($dblink);

echo "<div>";
echo "<form method='post' action='modify.php'>";
echo '<table style="float:left;">';
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

echo "<form method='post' action='modify.php'>";

echo '<table style="float:left;">';
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

echo "<form method='post' action='modify.php'>";
echo '<table style="float:left;">';
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
