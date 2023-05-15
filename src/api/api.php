<?php
require_once("../includers/config.php");
include_once(DIR_INCLUDERS . "baseApi.php");

$uri  = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$pathFragments = explode('/', $path);
$requester = end($pathFragments);


switch ($requester) {
    case 'dropdowns':
        header('Content-Type: application/json');
        header('HTTP/1.2 200 OK');
        $output = getSearchMenuArray();
        break;

    case 'results':
        header('Content-Type: application/json');
        header('HTTP/1.2 200 OK');
        $brand = (isset($_REQUEST['brand'])) ? $_REQUEST['brand'] : "all";
        $type = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : "all";
        $serial = (isset($_REQUEST['serial'])) ? $_REQUEST['serial'] : "";
        $offset = (isset($_REQUEST['offset'])) ? $_REQUEST['offset'] : 0;
        $output = getResults($brand, $type, $serial, $offset);
        break;

    case 'insertDevice':
        header('Content-Type: application/json');
        header('HTTP/1.2 200 OK');
        $brand = (isset($_REQUEST['brand'])) ? $_REQUEST['brand'] : "";
        $type = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : "";
        $serial = (isset($_REQUEST['serial'])) ? $_REQUEST['serial'] : "";
        $output = insertNewDevice($brand, $type, $serial);
        break;

    case 'insertBrand':
        header('Content-Type: application/json');
        header('HTTP/1.2 200 OK');
        $brand = (isset($_REQUEST['brand'])) ? $_REQUEST['brand'] : "";
        $output = insertNewBrand($brand);
        break;

    case 'insertType':
        header('Content-Type: application/json');
        header('HTTP/1.2 200 OK');
        $type = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : "";
        $output = insertNewType($type);
        break;

    default:
        header('Content-Type: application/json');
        header('HTTP/1.2 200 Not Found');
        $output = array();
        $output["status"] = "Bad";
        $output["msg"] = "Invalid Request";
        $output["action"] = "None";
        $output["timing"] = "";
        $output["data"] = "";   
        break;
}
$responseData = json_encode($output);
echo $responseData;
