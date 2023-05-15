<?php
require_once("../includers/config.php");
include_once(DIR_INCLUDERS . "baseQueries.php");
include_once(DIR_INCLUDERS . "timer.php");
function getSearchMenuArray()
{
    $dblink = db_connect("main");
    $data = array();
    $start = tStart();
    $data['brands'] = getArray($dblink, "brands");
    $data['types'] = getArray($dblink, "types");
    $timing = reportTime($dblink, addslashes("brands&types"), $start, sizeof($data), "dropDownsApi");

    $output = array();
    $output["status"] = "Good";
    $output["msg"] = "Brands and Types";
    $output["action"] = "Select";
    $output["timing"] = $timing;
    $output["data"] = $data;


    return $output;
}

function getResults($brand, $type, $serial, $offset)
{
    $dblink = db_connect("main");
    $data = array();
    $start = tStart();
    $length = 1000;
    $results = getEquipmentArray($dblink, $brand, $type, $serial, $offset, $length);

    if ($results[0] == "bad"){
        $timing = reportTime($dblink, addslashes("ERROR"), $start, sizeof($results), "resultsApi");
        $output = array();
        $output["status"] = "Bad";
        $output["msg"] = $results[1];
        $output["action"] = "Select";
        $output["timing"] = $timing;
        return $output;
    }
    $timing = reportTime($dblink, addslashes("equipment_production"), $start, sizeof($results), "resultsApi");

    $data['hasNext'] = (sizeof($results) >= $length) ? true : false;
    $data['results'] = $results;



    $output = array();
    $output["status"] = "Good";

    $output["msg"] = (sizeof($results) == 0) ? "No " : "";
    $serialMsg = ($serial == "") ? "Serial: All" : "Serial: $serial";
    $output["msg"] = $output["msg"] . "Brand:$brand Type:$type $serialMsg results";

    $output["action"] = "Select";
    $output["timing"] = $timing;
    $output["data"] = $data;

    return $output;
}

function insertNewDevice($brand, $type, $serial)
{
    $dblink = db_connect("main");
    $start = tStart();
    $data = array();
    if ($brand == "" or $type == "" or $serial == "") {
        $timing = reportTime($dblink, "ERROR" , $start, 1, "insertDeviceApi");
        $output = array();
        $output["status"] = "Bad";
        $output["msg"] = "Missing Data: ";

        $output["action"] = "None";
        $output['timing'] = $timing;

        $data['brand'] = ($brand != "") ? $brand : "";
        $data['type'] = ($type != "") ? $type : "";
        $data['serial'] = ($serial != "") ? $serial : "";

        $output["data"] = $data;
        return $output;
    }
    $id = smartInsertDevice($dblink, $type, $brand,  $serial);
    $timing = reportTime($dblink, addslashes("equipment_production"), $start, 1, "insertDeviceApi");
    $data['id'] = $id;
    $data['brand'] = $brand;
    $data['type'] = $type;
    $data['serial'] = $serial;

    $output = array();
    $output["status"] = "Good";
    $output["msg"] = "New Device: $brand $type $serial";
    $output["action"] = "Insert";
    $output['timing'] = $timing;
    $output["data"] = $data;

    return $output;
}

function insertNewBrand($brand){
    $dblink = db_connect("main");
    $start = tStart();
    $data = array();
    if ($brand == "") {
        $timing = reportTime($dblink, "ERROR", $start, 1, "insertBrandApi");
        $output = array();
        $output["status"] = "Bad";
        $output["msg"] = "Missing Data";
        $output["action"] = "None";
        $output['timing'] = $timing;

        return $output;
    }
    try{
        $id = insertBrand($dblink, $brand);

    } catch (Exception $e){
        $timing = reportTime($dblink, "ERROR", $start, 1, "insertBrandApi");
        $output = array();
        $output["status"] = "Bad";
        $output["msg"] = "Brand already exists";
        $output["action"] = "None";
        $output['timing'] = $timing;

        return $output;
    }

    $timing = reportTime($dblink, addslashes("brands"), $start, 1, "insertBrandApi");
    $data['id'] = $id;
    $data['brand'] = $brand;

    $output = array();
    $output["status"] = "Good";
    $output["msg"] = "New Brand: $brand";
    $output["action"] = "Insert";
    $output['timing'] = $timing;
    $output["data"] = $data;

    return $output;
}

function insertNewType($type){
    $dblink = db_connect("main");
    $start = tStart();
    $data = array();
    if ($type == "") {
        $timing = reportTime($dblink, "ERROR", $start, 1, "insertTypeApi");
        $output = array();
        $output["status"] = "Bad";
        $output["msg"] = "Missing Data";
        $output["action"] = "None";
        $output['timing'] = $timing;

        return $output;
    }
    try {
        $id = insertType($dblink, $type);
    } catch (Exception $e){
        $timing = reportTime($dblink, "ERROR", $start, 1, "insertTypeApi");
        $output = array();
        $output["status"] = "Bad";
        $output["msg"] = "Type already exists";
        $output["action"] = "None";
        $output['timing'] = $timing;

        return $output;
    }

    $timing = reportTime($dblink, "types", $start, 1, "insertTypeApi");
    $data['id'] = $id;
    $data['type'] = $type;

    $output = array();
    $output["status"] = "Good";
    $output["msg"] = "New Type: $type";
    $output["action"] = "Insert";
    $output['timing'] = $timing;
    $output["data"] = $data;

    return $output;
}

