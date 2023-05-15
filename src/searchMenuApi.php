<?php

require_once("./includers/config.php");


$ch = curl_init();
$url = URL."api/dropdowns";
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);

$result=curl_exec($ch);
$err = curl_error($ch);
if($err){
  echo "cURL Error #:" . $err;
}
// Closing
curl_close($ch);

$json = json_decode($result, true);

echo "<form method='post' action='resultsApi.php'>";

echo '<label for="brand">Brand:</label><br>';
echo "<select name='brand'>";
echo "<option value='all' selected>All</option>";
$brand = $json['data']['brands'];
foreach ($brand as $key => $value) {
    echo "<option value='$value'>$value</option>";
}
echo '</select>';
echo '</br>';

echo '<label for="type">Type:</label><br>';
echo "<select name='type'>";
echo "<option value='all' selected>All</option>";
$type = $json['data']['types'];
foreach ($type as $key => $value) {
    echo "<option value='$value'>$value</option>";
}
echo '</select>';
echo '</br>';

echo '<label for="serial">Serial Number (Optional):</label><br>';
echo '<input type="text" name="serial" value=""><br>';
echo '<input type="hidden" name="offset" value="0"><br>';

echo "<button type='submit' name='submit' value='submit'>Submit</button>";
echo '</form>';
