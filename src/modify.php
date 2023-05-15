<?php

include_once("includers/baseQueries.php");
include_once("includers/function.php");

if (!isset($_POST['modifyDevice']) && !isset($_POST['modifyBrand']) && !isset($_POST['modifyType']) && !isset($_POST['modifyInactive'])) {
    //redirect("./index.php");
}

if (isset($_POST['modifyDevice'])) {

    $dblink = db_connect("main");
    $id = $_POST['modifyDevice'];
    $current = getEquipmentArraySingle($dblink, $id);
    $brands = getArray($dblink, "brands");
    $types = getArray($dblink, "types");


    echo "<form method='post' action='modify.php'>";
    echo "<input type='hidden' name='table' value='equipment_production'>";
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
    echo "<input type=hidden name='deactivateName' value=$current[serial]></input>";
    echo "</tr>";

    echo "<tr>";
    echo "<td><button type='submit' name='changeEquipment' value='$id'>Change It</button></td>";
    echo "<td><input type='text' name='type' value='$current[type]'></td>";
    echo "<td><input type='text' name='brand' value='$current[brand]'></td>";
    echo "<td><input type='text' name='serial' value='$current[serial]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td><button type='submit' name='Deactivate' value='$id'>Deactivate It</button></td>";
    echo "</tr>";

    echo "</table>";
    echo "</form>";
} elseif (isset($_POST['modifyBrand'])) {
    $dblink = db_connect("main");
    $id = $_POST['modifyBrand'];
    $current = getArraySingle($dblink, "brands", $id);

    echo "<form method='post' action='modify.php'>";
    echo "<input type='hidden' name='table' value='brands'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Modify Brand</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>id</td>";
    echo "<td>name</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>$id</td>";
    echo "<td >$current[name]</td>";
    echo "<input type=hidden name='deactivateName' value=$current[name]></input>";
    echo "</tr>";

    echo "<tr>";
    echo "<td><button type='submit' name='changeBrand' value='$id'>Change It</button></td>";
    echo "<td><input type='text' name='name' value='$current[name]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td><button type='submit' name='Deactivate' value='$id'>Deactivate It</button></td>";
    echo "</tr>";

    echo "</table>";
    echo "</form>";
} elseif (isset($_POST['modifyType'])) {
    $dblink = db_connect("main");
    $id = $_POST['modifyType'];
    $current = getArraySingle($dblink, "types", $id);

    echo "<form method='post' action='modify.php'>";
    echo "<input type='hidden' name='table' value='types'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Modify Type</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>id</td>";
    echo "<td>name</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>$id</td>";
    echo "<td>$current[name]</td>";
    echo "<input type=hidden name='deactivateName' value=$current[name]></input>";
    echo "</tr>";

    echo "<tr>";
    echo "<td><button type='submit' name='changeType' value='$id'>Change It</button></td>";
    echo "<td><input type='text' name='name' value='$current[name]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td><button type='submit' name='Deactivate' value='$id'>Deactivate It</button></td>";
    echo "</tr>";

    echo "</table>";
    echo "</form>";
} elseif (isset($_POST['modifyInactive'])) {
    $dblink = db_connect("main");
    $id = $_POST['modifyInactive'];
    $current = getInactiveSingle($dblink, $id);
    if ($current['table'] == "equipment_production") {
        $brands = getArray($dblink, "brands");
        $types = getArray($dblink, "types");
        $reference = getEquipmentArraySingle($dblink, $current['key']);
        $reference['brand'] = $brands[$reference['brand']];
        $reference['type'] = $types[$reference['type']];
    } else {
        $reference = getArraySingle($dblink, $current['table'], $current['key']);
    }

    echo "<form method='post' action='modify.php'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Modify Inactive</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>id</td>";
    echo "<td>key</td>";
    echo "<td>table</td>";
    foreach ($reference as $key => $value) {
        echo "<td>$key</td>";
    }
    echo "</tr>";

    echo "<tr>";
    echo "<td>$id</td>";
    echo "<td>$current[key]</td>";
    echo "<td>$current[table]</td>";
    foreach ($reference as $key => $value) {
        echo "<td>$value</td>";
    }
    echo "</tr>";

    echo "<tr>";
    echo "<td><button type='submit' name='reactivate' value='$id'>Reactivate It</button></td>";
    echo "</tr>";

    echo "</table>";
    echo "</form>";
} elseif (isset($_POST['changeEquipment'])) {
    $dblink = db_connect("main");
    $id = $_POST['changeEquipment'];
    $type = $_POST['type'];
    $brand = $_POST['brand'];
    $serial = $_POST['serial'];
    modDevice($dblink, $id, $type, $brand, $serial);
} elseif (isset($_POST['changeBrand'])) {
    $dblink = db_connect("main");
    $id = $_POST['changeBrand'];
    $name = $_POST['name'];
    modBrand($dblink, $id, $name);
} elseif (isset($_POST['changeType'])) {
    $dblink = db_connect("main");
    $id = $_POST['changeType'];
    $name = $_POST['name'];
    modType($dblink, $id, $name);
} elseif (isset($_POST['Deactivate'])) {
    $dblink = db_connect("main");
    $id = $_POST['Deactivate'];
    $table = $_POST['table'];
    $name = $_POST['deactivateName'];

    deactivate($dblink, $table, $id, $name);
} elseif (isset($_POST['reactivate'])) {
    $dblink = delete_connect("main");
    $id = $_POST['reactivate'];
    reactivate($dblink, $id);
}

if (isset($_POST['changeEquipment']) or isset($_POST['changeBrand']) or isset($_POST['changeType']) or isset($_POST['Deactivate']) or isset($_POST['reactivate'])) {
?>
    <ul>
        <li><a href="./inactive.php">Change More</a><br></li>
    </ul>
    <ul>
        <li><a href="./index.php">Back to Start</a><br></li>
    </ul>

<?php

}
