<?php
include_once("dbInfo.php");
include_once("timer.php");
function insertQueryCSV($dblink, $table, $columni, $row)
{
    $columns = "";
    foreach ($columni as $value) {
        $columns = "$columns,`$value`";
    }
    $columns = trim($columns, ",");

    $rows = "";
    foreach ($row as $value) {
        $insert = addSlashes($value);
        $rows = "$rows,'$insert'";
    }
    $rows = trim($rows, ",");

    $sql = "INSERT INTO `$table` ($columns) VALUES ($rows)";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}

function db_connect($db)
{
    $dbInfo = dbInfo();
    $hostname = $dbInfo['hostname'];
    $username = $dbInfo['username'];
    $password = $dbInfo['password'];
    $dblink = new mysqli($hostname, $username, $password, $db);
    if (mysqli_connect_errno()) {
        die("Error connecting to database: " . mysqli_connect_error());
    }
    return $dblink;
}

function insertQueryAssoc($dblink, $table, $assoc)
{
    $columns = "";
    $rows = "";

    foreach ($assoc as $x => $x_value) {
        $insert = addSlashes($x_value);

        $columns = "$columns,`$x`";
        $rows = "$rows,`$insert`";
    }

    $columns = trim($columns, ",");
    $rows = trim($rows, ",");


    $sql = "INSERT INTO `$table` ($columns) VALUES ($rows)";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}

function commit($dblink)
{
    if (!mysqli_commit($dblink)) {
        print("Transaction commit failed\n");
    }
}

function autoOff($dblink)
{
    $sql = "Set autocommit=0;";
    $dblink->query($sql) or
        die("Something went wrong with <br>Query: $sql<br>\n" . $dblink->error);
}

function getDropDown($dblink, $table)
{
    $time_start = tStart();
    $inactives = getInactiveString($dblink, $table);
    $inactives = ($inactives == "") ? "" : "WHERE `id` NOT IN ($inactives)";
    $sql = "SELECT `name`,`id` from `$table` $inactives";
    // echo $sql . "</br>";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);

    logTime($dblink, $table, $time_start, $result->num_rows, "get$table");
    return $result;
}

function getArray($dblink, $table)
{
    $result = getDropDown($dblink, $table);
    // $returner = [];
    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
        $idi = $data['id'];
        $returner[$idi] = $data['name'];
    }
    // var_dump( $returner);
    return $returner;
}

function isGeneric($quality)
{
    return ($quality == 'all' or $quality == '');
}

function getEquipment($dblink, $brand, $type, $serial, $offset, $length)
{
    return getEquipmentActive($dblink, $brand, $type, $serial, $offset, $length);
}

function getEquipmentActive($dblink, $brand, $type, $serial, $offset, $length)
{

    $brandSql = (isGeneric($brand)) ? "`brand` like '%%'" : "`brand` = '$brand'";
    $typeSql = (isGeneric($type)) ? "`type` like '%%'" : "`type` = '$type'";
    $serialSql = (isGeneric($serial)) ? "`serial` like '%%'" : "`serial` like '%$serial%'";
    $exclusions = getAllInactiveString($dblink);
    $exclusions = ($exclusions == "") ? "" : "and $exclusions";

    $sql = " SELECT `id`,`brand`,`type`,`serial` 
            from `equipment_production`
            where $brandSql 
            and $typeSql 
            and $serialSql
            $exclusions 
            ORDER BY `id`
            LIMIT $offset,$length";
    // echo $sql."</br>";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);


    return $result;
}



function insertDevice($dblink, $type, $brand, $serial)
{
    $type = addSlashes($type);
    $brand = addSlashes($brand);
    $serial = addSlashes($serial);

    $sql = "INSERT INTO `equipment_production` ( `type`, `brand`, `serial`) VALUES ('$type', '$brand', '$serial')";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    return $dblink->insert_id;
}

function smartInsertDevice($dblink, $type, $brand, $serial)
{
    $brandID = checkBrand($dblink, $brand);
    if (!$brandID) {
        $brandID = insertBrand($dblink, $brand);
    }

    $typeID = checkType($dblink, $type);
    if (!$typeID) {
        $typeID = insertType($dblink, $type);
    }

    return insertDevice($dblink, $type, $brand, $serial);
}

function checkBrand($dblink, $brand)
{
    $sql = "SELECT `id` FROM `brands` WHERE `name` = '$brand'";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    $data = $result->fetch_array(MYSQLI_ASSOC);
    return ($result->num_rows) ? $data['id'] : false;
}

function checkType($dblink, $type)
{
    $sql = "SELECT `id` FROM `types` WHERE `name` = '$type'";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    $data = $result->fetch_array(MYSQLI_ASSOC);
    return ($result->num_rows) ? $data['id'] : false;
}

function insertBrand($dblink, $brand)
{
    $brand = addslashes($brand);
    $sql = "INSERT INTO `brands` (`name`) VALUES ('$brand')";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    return $dblink->insert_id;
}

function insertType($dblink, $type)
{
    $type = addslashes($type);
    $sql = "INSERT INTO `types` (`name`) VALUES ('$type')";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    return $dblink->insert_id;
}



function modDevice($dblink, $type, $brand, $serial, $active)
{
    $sql = "UPDATE `equipment_production` SET `type` = '2', `brand` = '3' WHERE `equipment_production`.`id` = 5171675";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}
function modBrand($dblink, $brand)
{
    $sql = "INSERT INTO `brands` (`name`) VALUES ('$brand')";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}
function modType($dblink, $type)
{
    $sql = "INSERT INTO `types` (`name`) VALUES ('$type')";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}

function makeInactive($dblink, $table, $key)
{
    $sql = "INSERT INTO `inactive` (`table`, `key`) VALUES ('$table', '$key')";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}

function getInactiveString($dblink, $table)
{
    $sql = "SELECT `key` FROM `inactive` WHERE `table` = '$table'";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    $returner = "";
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

        $returner = $returner . "'$row[key]',";
    }
    return rtrim($returner, ',');
}
function getAllInactiveString($dblink)
{
    $thing['types'] =  getInactiveString($dblink, 'types');
    $thing['brands'] = getInactiveString($dblink, 'brands');
    $thing['serial'] = getInactiveString($dblink, 'equipment_production');


    if ($thing['types'] == "") {
        unset($thing['types']);
    } else {
        $thing['types'] = "`type` not in ($thing[types])";
    }

    if ($thing['brands'] == "") {
        unset($thing['brands']);
    } else {
        $thing['brands'] = "`brand` not in ($thing[brands])";
    }

    if ($thing['serial'] == "") {
        unset($thing['serial']);
    } else {
        $thing['serial'] = "`serial` not in ($thing[serial])";
    }

    $returner = "";
    foreach ($thing as $key => $value) {
        $returner = $returner . $value . " and ";
    }
    return rtrim($returner, " and ");
}

function getInactiveArray($dblink)
{

    $sql = "SELECT `id`,`table`, `key` FROM `inactive`";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    $returner = array();
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

        $returner[$row['id']] = ["table" => $row['table'], 'key' => $row['key']];
    }
    return $returner;
}

function getEquipmentArray($dblink, $brand, $type, $serial, $offset, $length)
{
    $result = getEquipmentActive($dblink, $brand, $type, $serial, $offset, $length);
    $fields = array('id', 'type', 'brand', 'serial', 'active');
    $returner = array();
    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
        $idi = $data['id'];
        $temp = array();
        foreach ($fields as $field) {
            $temp[$field] = $data[$field];
        }
        $returner[$idi] = $temp;
    }
    return $returner;
}
