<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <style>
    body {
      width: 35em;
      margin: 0 auto;
      font-family: Tahoma, Verdana, Arial, sans-serif;
    }
  </style>
  <title>Insert Menu!</title>
</head>

<body>
  <?php


  include_once("includers/timer.php");
  include_once("includers/baseQueries.php");
  $dblink = db_connect("main");
  if (!isset($_POST['submit'])) {
  ?>
    <div class="mb-3">
      <form method='post' action='insert.php'>
        <table class="table">
          <tr>
            <td></td>
            <td>New Device</td>
          </tr>
          <tr>
            <td>Brand</td>
            <td><select name='brand' class="form-select">
                <?php
                $brand = getArray($dblink, "brands");
                foreach ($brand as $key => $value) {
                  echo "<option value='$value'>$value</option>";
                }
                ?>
              </select></td>
          </tr>
          <tr>
            <td>Type</td>
            <td><select name='type' class="form-select">
                <?php
                $type = getArray($dblink, "types");
                foreach ($type as $key => $value) {
                  echo "<option value='$value'>$value</option>";
                }
                ?>
              </select></td>
          </tr>
          <tr>
            <td>Serial</td>
            <td><input type="text" class="form-control" name="serial" value=""></td>
          </tr>
          <tr>
            <td></td>
            <td><button type='submit' name='submit' value='insertDevice' class="btn btn-primary">Submit</button></td>
          </tr>
        </table>
      </form>
    </div>
    <div class="mb-3">
      <form method='post' action='insert.php'>
        <table class="table">
          <tr>
            <td></td>
            <td>New Brand</td>
          </tr>
          <tr>
            <td>Brand</td>
            <td><input type="text" class="form-control" name="brandHard" value=""></td>
          </tr>

          <tr>
            <td></td>
            <td><button type='submit' name='submit' value='insertBrand' class="btn btn-primary">Submit</button></td>
          </tr>
        </table>
      </form>
    </div>
    <div class="mb-3">
      <form method='post' action='insert.php'>
        <table class="table">
          <tr>
            <td></td>
            <td>New Type</td>
          </tr>

          <tr>
            <td>Type</td>
            <td><input type="text" class="form-control" name="typeHard" value=""></td>
          </tr>

          <tr>
            <td></td>
            <td><button type='submit' name='submit' value='insertType' class="btn btn-primary">Submit</button></td>
          </tr>
        </table>
      </form>
    </div>
  <?php
  } elseif ($_POST['submit'] == 'insertDevice' and $_POST['serial']) {
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $serial = $_POST['serial'];

    $result = smartInsertDevice($dblink, $type, $brand, $serial);

    if ($result) {
      echo "<h3>Device $brand $type #$serial inserted successfully at $result <h3>";
    } else {
      echo "<h3>Device not inserted<h3>";
    }
  } elseif ($_POST['submit'] == 'insertBrand' and $_POST['brandHard']) {
    $brand = $_POST['brandHard'];
    try {
      $result = insertBrand($dblink, $brand);
      echo "<h3>Brand $brand inserted successfully at $result<h3>";
    } catch (Exception $e) {
      echo "<h3>Brand $brand not inserted<h3>";
    }
  } elseif ($_POST['submit'] == 'insertType' and $_POST['typeHard']) {
    $type = $_POST['typeHard'];
    try {
      $result = insertType($dblink, $type);
      echo "<h3>Type $type inserted successfully at $result<h3>";
    } catch (Exception $e) {
      echo "<h3>Type $type not inserted<h3>";
    }
  }

  if (isset($_POST['submit'])) {
  ?>
    <ul class="list-group">
      <li><a href="./insert.php">Insert More</a><br></li>
      <li><a href="./index.php">Back to Start</a><br></li>
    </ul>

  <?php
  }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>