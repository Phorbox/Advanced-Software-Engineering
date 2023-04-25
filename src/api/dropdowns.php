<?php
header('Content-Type: application/json');
header('HTTP/1.2 200 OK');
require("../includers/config.php");
include_once(DIR_INCLUDERS . "baseApi.php");
$output = getSearchMenuArray();
// $output = getResults($_POST['brand'],$_POST['type'],$_POST['serial'],$_POST['offset']);
// $output = getResults('all','all','',0);

$responseData = json_encode($output);
echo $responseData;