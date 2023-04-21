<?php


include_once("includers/timer.php");
include_once("includers/baseQueries.php");
$dblink = db_connect("main");
if (!isset($_POST['submit'])) {
?>
  <form method='post' action='insert.php'>
    <table>
      <tr>
        <td></td>
        <td>New Device</td>
      </tr>
      <tr>
        <td>Brand</td>
        <td><select name='brand'>
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
        <td><select name='type'>
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
        <td><input type="text" name="serial" value=""></td>
      </tr>
      <tr>
        <td></td>
        <td><button type='submit' name='submit' value='insertDevice'>Submit</button></td>
      </tr>
    </table>
  </form>

  <form method='post' action='insert.php'>
    <table>
      <tr>
        <td></td>
        <td>New Brand</td>
      </tr>
      <tr>
        <td>Brand</td>
        <td><input type="text" name="brandHard" value=""></td>
      </tr>

      <tr>
        <td></td>
        <td><button type='submit' name='submit' value='insertBrand'>Submit</button></td>
      </tr>
    </table>
  </form>

  <form method='post' action='insert.php'>
    <table>
      <tr>
        <td></td>
        <td>New Type</td>
      </tr>

      <tr>
        <td>Type</td>
        <td><input type="text" name="typeHard" value=""></td>
      </tr>

      <tr>
        <td></td>
        <td><button type='submit' name='submit' value='insertType'>Submit</button></td>
      </tr>
    </table>
  </form>
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
  $brand = $_POST['brand'];
  $result = insertBrand($dblink, $brand);
  if ($result) {
    echo "<h3>Brand $brand inserted successfully at $result<h3>";
  } else {
    echo "<h3>Brand not inserted<h3>";
  }
} elseif ($_POST['submit'] == 'insertType' and $_POST['typeHard']) {
  $type = $_POST['type'];
  $result = insertType($dblink, $type);
  if ($result) {
    echo "<h3>Type $type inserted successfully at $result<h3>";
  } else {
    echo "<h3>Type not inserted<h3>";
  }
}

if (isset($_POST['submit'])) {
?>
  <ul>
    <li><a href="./insert.php">Insert More</a><br></li>
  </ul>
  <ul>
    <li><a href="./index.php">Back to Start</a><br></li>
  </ul>

<?php
}
