<?php
require("../includers/config.php");
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

    default:
        echo "<h1>API</h1>";
        break;
}
$responseData = json_encode($output);
echo $responseData;
