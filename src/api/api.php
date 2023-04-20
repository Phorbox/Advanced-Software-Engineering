<?php
header('Content-Type: application/json');
header('HTTP/1.2 200 OK');
$output = array();
$data = array();
$output["status"] = "API Main";
$output["msg"] = "primary endpoint";
$data["test"] = "test";
$data["array"] = [1,2,3,4,5];
$output["data"] = $data;
$output["action"] = "none";

$responseData = json_encode($output);
echo $responseData;