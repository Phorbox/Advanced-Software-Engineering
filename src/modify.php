<?php

include_once("includers/baseQueries.php");
include_once("includers/function.php");
if (!isset($_POST['modifyDevice']) && !isset($_POST['modifyBrand']) && !isset($_POST['modifyType']) && !isset($_POST['modifyInactive'])) {
    redirect("./index.php");
}

if (isset($_POST['modifyDevice'])) {
    $dblink = db_connect("main");
    $id = $_POST['modifyDevice'];
    $current = getEquipmentArraySingle($dblink, $id);
    $brands = getArray($dblink, "brands");
    $types = getArray($dblink, "types");


    echo "<form method='post' action=''>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Modify Device</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>id</td>";
    echo "<td>type</td>";
    echo "<td>brand</td>";
    echo "<td>serial</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>$id</td>";
    $brand = $brands[$current['brand']];
    echo "<td>$brand</td>";
    $type = $types[$current['type']];
    echo "<td>$type</td>";
    echo "<td>$current[serial]</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td><button type='submit' name='changeit' value='equipment_production'>Change It</button></td>";
    echo "<td><input type='text' name='type' value=''></td>";
    echo "<td><input type='text' name='brand' value=''></td>";
    echo "<td><input type='text' name='serial' value=''></td>";
    echo "</tr>";

    echo "</table>";
    echo "</form>";
} else if (isset($_POST['modifyBrand'])) {
} else if (isset($_POST['modifyType'])) {
} else if (isset($_POST['modifyInactive'])) {
} else {
}
