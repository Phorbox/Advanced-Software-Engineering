<?php
include_once("timer.php");
include_once("baseQueries.php");


$dblink = db_connect("main");

echo "<form method='post' action='results.php'>";

$brand = getDropDown($dblink,"brands");
echo '<label for="brand">Brand:</label><br>';
echo "<select name='brand'>";
echo "<option value='all' selected>All</option>";
while($dataB=$brand->fetch_array(MYSQLI_NUM)){
    echo "<option value='$dataB[1]'>$dataB[0]</option>";
}
echo '</select>';
echo '</br>';

$type = getDropDown($dblink,"types");
echo '<label for="type">Type:</label><br>';
echo "<select name='type'>";
echo "<option value='all' selected>All</option>";
while($dataT=$type->fetch_array(MYSQLI_NUM)){
    echo "<option value='$dataT[1]'>$dataT[0]</option>";
}
echo '</select>';
echo '</br>';

echo '<label for="serial">Serial Number (Optional):</label><br>';
echo '<input type="text" name="serial" value=""><br>';
echo '<input type="hidden" name="offset" value="0"><br>';

echo "<button type='submit' name='submit' value='submit'>Submit</button>";
echo '</form>';