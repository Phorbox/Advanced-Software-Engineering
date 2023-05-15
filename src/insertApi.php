<?php


require_once("./includers/config.php");

if (!isset($_POST['submit'])) {
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

  echo "<form method='post' action='insertApi.php'>";
  echo " <table>";
  echo " <tr>";
  echo " <td></td>";
  echo " <td>New Device</td>";
  echo " </tr>";
  echo " <tr>";
  echo " <td>Brand</td>";
  echo " <td><select name='brand'>";

  $brand = $json['data']['brands'];
  foreach ($brand as $key => $value) {
    echo "<option value='$value'>$value</option>";
  }

  echo " </select></td>";
  echo " </tr>";
  echo " <tr>";
  echo " <td>Type</td>";
  echo " <td><select name='type'>";

  $type = $json['data']['types'];
  foreach ($type as $key => $value) {
    echo "<option value='$value'>$value</option>";
  }

  echo " </select></td>";
  echo " </tr>";
  echo " <tr>";
  echo " <td>Serial</td>";
  echo ' <td><input type="text" name="serial" value=""></td>';
  echo " </tr>";
  echo " <tr>";
  echo " <td></td>";
  echo " <td><button type='submit' name='submit' value='insertDevice'>Submit</button></td>";
  echo " </tr>";
  echo " </table>";
  echo "</form>";

  echo " <form method='post' action='insertApi.php'>";
  echo " <table>";
  echo " <tr>";
  echo " <td></td>";
  echo " <td>New Brand</td>";
  echo " </tr>";
  echo " <tr>";
  echo " <td>Brand</td>";
  echo ' <td><input type="text" name="brandHard" value=""></td>';
  echo " </tr>";
  echo " <tr>";
  echo " <td></td>";
  echo " <td><button type='submit' name='submit' value='insertBrand'>Submit</button></td>";
  echo " </tr>";
  echo " </table>";
  echo " </form>";

  echo " <form method='post' action='insertApi.php'>";
  echo " <table>";
  echo " <tr>";
  echo " <td></td>";
  echo " <td>New Type</td>";
  echo " </tr>";

  echo " <tr>";
  echo " <td>Type</td>";
  echo ' <td><input type="text" name="typeHard" value=""></td>';
  echo " </tr>";

  echo " <tr>";
  echo " <td></td>";
  echo " <td><button type='submit' name='submit' value='insertType'>Submit</button></td>";
  echo " </tr>";
  echo " </table>";
  echo " </form>";
} elseif ($_POST['submit'] == 'insertDevice' and $_POST['serial']) {
  $brand = $_POST['brand'];
  $type = $_POST['type'];
  $serial = urlencode($_POST['serial']);


  $ch = curl_init();
  $url = URL."api/insertDevice?brand=$brand&type=$type&serial=$serial";

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
  $newBrand = $json['data']['brand'];
  $newType = $json['data']['type'];
  $newSerial = $json['data']['serial'];
  $newId = $json['data']['id'];



  if ($json) {
    echo "<h3>Device $newBrand $newType #$newSerial inserted successfully at $newId <h3>";
  } else {
    echo "<h3>Device not inserted<h3>";
  }
} elseif ($_POST['submit'] == 'insertBrand' and $_POST['brandHard']) {
  $brand = $_POST['brandHard'];
  $ch = curl_init();
  $url = URL."api/insertBrand?brand=$brand";
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
  $newBrand = $json['data']['brand'];
  $newId = $json['data']['id'];
  if ($json) {
    echo "<h3>Brand $newBrand inserted successfully at $newId<h3>";
  } else {
    echo "<h3>Brand $brand not inserted<h3>";
  }
} elseif ($_POST['submit'] == 'insertType' and $_POST['typeHard']) {
  $type = $_POST['typeHard'];
  $ch = curl_init();
  $url = URL."api/insertType?type=$type";
  // echo $url."<br>";
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
  // print_r($json);
  $newType = $json['data']['type'];
  $newId = $json['data']['id'];



  if ($json) {
    echo "<h3>Type $newType inserted successfully at $newId<h3>";
  } else {
    echo "<h3>Type $type not inserted<h3>";
  }
}

if (isset($_POST['submit'])) {

  echo '<ul>';
  echo '<li><a href="./insertApi.php">Insert More</a><br></li>';
  echo '</ul>';
  echo '<ul>';
  echo '<li><a href="./index.php">Back to Start</a><br></li>';
  echo '</ul>';
}
