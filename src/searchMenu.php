<?php
include_once("includers/timer.php");
include_once("includers/baseQueries.php");


$dblink = db_connect("main");

echo "<form method='post' action='results.php'>";

echo '<label for="brand">Brand:</label><br>';
echo "<select name='brand'>";
echo "<option value='all' selected>All</option>";
$brand = getArray($dblink, "brands");
foreach ($brand as $key => $value) {
    echo "<option value='$key'>$value</option>";
}
echo '</select>';
echo '</br>';

echo '<label for="type">Type:</label><br>';
echo "<select name='type'>";
echo "<option value='all' selected>All</option>";
$type = getArray($dblink, "types");
foreach ($type as $key => $value) {
    echo "<option value='$key'>$value</option>";
}
echo '</select>';
echo '</br>';

echo '<label for="serial">Serial Number (Optional):</label><br>';
echo '<input type="text" name="serial" value=""><br>';
echo '<input type="hidden" name="offset" value="0"><br>';

echo "<button type='submit' name='submit' value='submit'>Submit</button>";
echo '</form>';
