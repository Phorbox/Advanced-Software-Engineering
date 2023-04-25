<?php
// header('Content-Type: application/json');
// header('HTTP/1.2 200 OK');
// require("../includers/config.php");
// include_once(DIR_INCLUDERS . "baseApi.php");
// $output = getSearchMenuArray();

$uri  = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$pathFragments = explode('/', $path);
$requester = end($pathFragments);
echo "<h3>$requester</h3>";
print_r($_REQUEST);




// $output = getResults($_POST['brand'],$_POST['type'],$_POST['serial'],$_POST['offset']);
// $output = getResults('all','all','',0);

// $responseData = json_encode($output);
echo $responseData;