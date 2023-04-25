<?php
require("../includers/config.php");
include_once(DIR_INCLUDERS . "baseQueries.php");
function getSearchMenuArray()
{
    $dblink = db_connect("main");
    $data = array();
    $data['brands'] = getArray($dblink, "brands");
    $data['types'] = getArray($dblink, "types");

    $output = array();
    $output["status"] = "good";
    $output["msg"] = "Brands and Types";
    $output["action"] = "none";
    $output["data"] = $data;

    return $output;
}

function getResults($brand, $type, $serial, $offset)
{
    $dblink = db_connect("main");
    $data = array();
    $length = 1000;
    $results = getEquipmentArray($dblink, $brand, $type, $serial, $offset, $length);
    $data['hasNext'] = (sizeof($results) >= $length) ? true : false;
    $data['results'] = $results;

    $output = array();
    $output["status"] = "good";
    $output["msg"] = "results";
    $output["action"] = "none";
    $output["data"] = $data;

    return $output;
}
