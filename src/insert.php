<?php
if(!isset($_POST['insertDevice']) and !isset($_POST['insertBrand']) and !isset($_POST['insertType'])){
    include_once("timer.php");
    include_once("baseQueries.php");


    $dblink = db_connect("main");
    $brand = getDropDown($dblink,"brands");
    
    echo "<form method='post' action='insert.php'>";
    echo '<table>';
    echo '<tr>';
    echo "<td></td>"; 
    echo "<td>New Device</td>"; 
    echo '</tr>';
    
    echo '<tr>';
    echo "<td>Brand</td>"; 
    echo "<td><select name='brand'>";
    echo "<option value='' selected></option>";
    while($dataB=$brand->fetch_array(MYSQLI_NUM)){
        echo "<option value='$dataB[1]'>$dataB[0]</option>";
    }
    echo '</select></td>';
    echo '</tr>';
    
    $type = getDropDown($dblink,"types");
    echo '<tr>';
    echo "<td>Type</td>"; 
    echo "<td><select name='type'>";
    echo "<option value='' selected></option>";
    while($dataB=$type->fetch_array(MYSQLI_NUM)){
        echo "<option value='$dataB[1]'>$dataB[0]</option>";
    }
    echo '</select></td>';
    echo '</tr>';
    
    
    echo '<tr>';
    echo "<td>Serial</td>"; 
    echo '<td><input type="text" name="serial" value=""></td>'; 
    echo '</tr>';
    
    echo '<tr>';
    echo "<td></td>";
    echo "<td><button type='submit' name='insertDevice' value='insertDevice'>Submit</button></td>"; 
    echo '</tr>';
    echo '</table>';
    echo '</form>';
    
    
    echo "<form method='post' action='insert.php'>";
    echo '<table>';
    echo '<tr>';
    echo "<td></td>"; 
    echo "<td>New Brand</td>"; 
    echo '</tr>';
    
    echo '<tr>';
    echo "<td>Brand</td>"; 
    echo '<td><input type="text" name="brand" value=""></td>'; 
    echo '</tr>';
    
    echo '<tr>'; 
    echo "<td></td>"; 
    echo "<td><button type='submit' name='insertBrand' value='insertBrand'>Submit</button></td>"; 
    echo '</tr>';
    echo '</table>';
    echo '</form>';
    
    echo "<form method='post' action='insert.php'>";
    echo '<table>';
    echo '<tr>';
    echo "<td></td>"; 
    echo "<td>New Type</td>"; 
    echo '</tr>';
    
    echo '<tr>';
    echo "<td>Type</td>"; 
    echo '<td><input type="text" name="type" value=""></td>'; 
    echo '</tr>';
    
    echo '<tr>'; 
    echo "<td></td>"; 
    echo "<td><button type='submit' name='insertType' value='insertType'>Submit</button></td>"; 
    echo '</tr>';
    echo '</table>';
    echo '</form>';
} 
else if(isset($_POST['insertDevice']) and !isset($_POST['insertBrand']) and !isset($_POST['insertType'])){
    include_once("timer.php");
    include_once("baseQueries.php");
    $dblink = db_connect("main");
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $serial = $_POST['serial'];
   
    $result = smartInsertDevice($dblink, $type, $brand, $serial);
    
    if($result){
        echo "<h3>Device $brand $type #$serial inserted successfully at $result <h3>";
    }
    else{
        echo "<h3>Device not inserted<h3>";
    }
}
else if(!isset($_POST['insertDevice']) and isset($_POST['insertBrand']) and !isset($_POST['insertType'])){
    include_once("timer.php");
    include_once("baseQueries.php");
    $dblink = db_connect("main");
    $brand = $_POST['brand'];
   
    $result = insertBrand($dblink, $brand);
    if($result){
        echo "<h3>Brand $brand inserted successfully at $result<h3>";
    }
    else{
        echo "<h3>Brand not inserted<h3>";
    }
    
}
elseif (!isset($_POST['insertDevice']) and !isset($_POST['insertBrand']) and isset($_POST['insertType'])) {
    include_once("timer.php");
    include_once("baseQueries.php");
    $dblink = db_connect("main");
    $type = $_POST['type'];

    $result = insertType($dblink, $type);
    if($result){
        echo "<h3>Type $type inserted successfully at $result<h3>";
    }
    else{
        echo "<h3>Type not inserted<h3>";
    }
    
}



