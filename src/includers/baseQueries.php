<?php
require_once("config.php");
include_once(DIR_INCLUDERS . "timer.php");
include_once(DIR_INCLUDERS . "dbInfo.php");

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
function delete_connect($db)
{
    $dbInfo = deleteInfo();
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
    $brand = addslashes($brand);
    $type = addslashes($type);
    $serial = addslashes($serial);

    $brandSql = (isGeneric($brand)) ? "`brand` like '%%'" : "`brand` = '$brand'";
    $typeSql = (isGeneric($type)) ? "`type` like '%%'" : "`type` = '$type'";
    $serialSql = (isGeneric($serial)) ? "`serial` like '%%'" : "`serial` like '%$serial%'";

    $exclusions = getAllInactiveString($dblink);
    $exclusions = ($exclusions == "") ? "" : "and $exclusions";

    $sql = " SELECT `id`,`brand`,`type`,`serial` 
            from `equipment_production` as ep
            where $brandSql 
            and $typeSql 
            and $serialSql
            $exclusions 
            ORDER BY `id`
            LIMIT $offset,$length";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);


    return $result;
}
function getEquipmentActiveJoin($dblink, $brand, $type, $serial, $offset, $length)
{
    // $brand =    cleanBrand($brand);
    // $type =     cleantype($type);
    // $serial =   addslashes($serial);


    $where['specifics'] = getAllSpecificString($brand, $type, $serial);
    $where['exclusions'] = getAllInactiveString($dblink);
    // print_r($where);
    $wherer = "";
    foreach ($where as $key => $value) {
        $wherer = $wherer . $value . " and ";
    }
    $wherer =  trim($wherer, " and ");
    $wherer = ($wherer == "") ? "" : "WHERE $wherer";


    $sql = " SELECT 
            `ep`.`id` as `id`,
            `br`.`name` as `brand`,
            `ty`.`name` as `type`,
            `serial` 
            from `equipment_production` ep
            Inner Join `types` ty
            on `ty`.`id` = `ep`.`type`
            Inner Join `brands` br
            on `br`.`id` = `ep`.`brand`
            $wherer
            ORDER BY `ep`.`id`
            LIMIT $offset,$length";

    // $sql = " SELECT 
    //         `ep`.`id` as `id`,
    //         `brand`,
    //         `type`,
    //         `serial` 
    //         from `equipment_production` ep
    //         $returner
    //         ORDER BY `ep`.`id`
    //         LIMIT $offset,$length";
    // echo $sql;
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    return $result;
}

function cleanBrand($brand)
{
    $stuff = curlDropdowns();
    $brands = $stuff['brands'];
    
    
    return addslashes(array_search($brand,$brands));
    
}
function cleanType($type)
{
    $stuff = curlDropdowns();
    $types = $stuff['types'];
    
    
    return addslashes(array_search($type,$types));
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
    if ($brandID == false) {
        $brandID = insertBrand($dblink, $brand);
    }
    $typeID = checkType($dblink, $type);
    if ($typeID == false) {
        $typeID = insertType($dblink, $type);
    }
    return insertDevice($dblink, $typeID, $brandID, $serial);
}
function checkBrand($dblink, $brand)
{
    $sql = "SELECT `id` FROM `brands` WHERE `name` = '$brand'";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    $data = $result->fetch_array(MYSQLI_ASSOC);
    return ($result->num_rows != 0) ? $data['id'] : false;
}
function checkType($dblink, $type)
{
    $sql = "SELECT `id` FROM `types` WHERE `name` = '$type'";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    $numRows = $result->num_rows;
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $numRows = $result->num_rows;
    return ($result->num_rows != 0) ? $data['id'] : false;
}
function insertBrand($dblink, $brand)
{
    return insertCategory($dblink, $brand, "brands");
}
function insertType($dblink, $type)
{
    return insertCategory($dblink, $type, "types");
   
}
function insertCategory($dblink, $type, $table)
{
    $type = addslashes($type);
    $sql = "INSERT INTO `$table` (`name`) VALUES ('$type')";
    
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    return $dblink->insert_id;
}
function modDevice($dblink, $id, $type, $brand, $serial)
{
    $sql = "UPDATE equipment_production SET type = '$type', brand = '$brand', serial = '$serial' WHERE id = $id";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}
function modBrand($dblink, $id, $name)
{
    $sql = "UPDATE brands SET name = '$name' WHERE id = $id";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}
function modType($dblink, $id, $name)
{
    $sql = "UPDATE types SET name = '$name' WHERE id = $id";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}
function deactivate($dblink, $table, $key, $name)
{
    $sql = "INSERT INTO `inactive` (`table`, `key`, `name`) VALUES ('$table', '$key', '$name')";
    $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
}
function reactivate($deletelink, $id)
{
    $sql = "DELETE FROM `inactive` WHERE `id` = '$id'";
    $deletelink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $deletelink->error);
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
        $thing['serial'] = "`ep`.`id` not in ($thing[serial])";
    }
    $returner = "";
    foreach ($thing as $key => $value) {
        $returner = $returner . $value . " and ";
    }
    return rtrim($returner, " and ");
}

function getAllSpecificString($brand, $type, $serial)
{
    $thing = array();
    $brand = addslashes($brand);
    $type = addslashes($type);
    $serial = addslashes($serial);

    (isGeneric($brand)) ?:  $thing['brands'] = "`brand`  = '$brand'";
    (isGeneric($type)) ?:   $thing['types'] =  "`type` = '$type'";
    (isGeneric($serial)) ?: $thing['serial'] =  "`serial` like '%$serial%'";
    $returner = "";
    foreach ($thing as $key => $value) {
        $returner = $returner . $value . " and ";
    }
    return rtrim($returner, " and ");
}

function getInactiveArray($dblink)
{
    $sql = "SELECT `id`,`table`, `key`,`name` FROM `inactive`";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    $returner = array();
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $returner[$row['id']] = ["table" => $row['table'], 'key' => $row['key'], 'name' => $row['name']];
    }
    return $returner;
}
function getEquipmentArray($dblink, $brand, $type, $serial, $offset, $length)
{
    $brandId =  nameToNumber( "brands", $brand);
    $typeId =   nameToNumber( "types", $type); 

    if ($brandId == false or $typeId == false) {
        $msg = "Bad ";
        $msg = ($brandId == null)? $msg."Brand:$brand " : $msg;
        $msg = ($typeId == null)? $msg."Type:$type " : $msg;

        return ["bad",trim($msg)];
    }

    $result = getEquipmentActiveJoin($dblink, $brandId, $typeId, $serial, $offset, $length);
    $returner = array();

    // $json = curlDropdowns();
    // $brands = $json['brands'];
    // $types = $json['types'];


    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
        $temp['id'] = $data['id'];
        $temp['brand'] = $data['brand'];
        $temp['type'] = $data['type'];
        // $temp['brand'] = $brands[$data['brand']];
        // $temp['type'] = $types[$data['type']];
        $temp['serial'] = $data['serial'];
        $returner[] = $temp;
    }
    return $returner;
}

// returns id# if good brand, 
//       all if all, 
//       false if non existent brand
function nameToNumber($table, $name)
{
    $lowerName = strtolower($name);
    // echo $lowerName;
    if ($lowerName == "all") {
        return "all";
    }
    $index = curlDropdowns();
    $map = array_map('strtolower',$index[$table]);
    $returner = array_search($lowerName,$map);
    if($returner == null){
        return false;
    }
    
    return $returner;
}

function getEquipmentArraySingle($dblink, $id)
{
    $sql = "SELECT `brand`, `type`, `serial` FROM `equipment_production` WHERE `id` = '$id'";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    // $fields = array( 'type', 'brand', 'serial');
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $temp = array();
    foreach ($data as $key => $value) {
        $temp[$key] = $value;
    }
    return $temp;
}
function getArraySingle($dblink, $table, $id)
{
    $sql = "SELECT `name` FROM `$table` WHERE `id` = '$id'";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    // $fields = array( 'type', 'brand', 'serial');
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $temp = array();
    foreach ($data as $key => $value) {
        $temp[$key] = $value;
    }
    return $temp;
}
function getInactiveSingle($dblink, $id)
{
    $sql = "SELECT `id`,`table`,`key` FROM `inactive` WHERE `id` = '$id'";
    $result = $dblink->query($sql) or
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    // $fields = array( 'type', 'brand', 'serial');
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $temp = array();
    foreach ($data as $key => $value) {
        $temp[$key] = $value;
    }
    return $temp;
}


function  curlDropdowns(){
    $ch = curl_init();
    $url = URL . "api/dropdowns";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $request = curl_exec($ch);
    $err = curl_error($ch);
    if ($err) {
        echo "cURL Error #:" . $err;
    }
    // Closing
    curl_close($ch);
    /// echo $request;
    $json = json_decode($request, true);

    return $json['data'];
}

