<?php

include_once("includers/function.php");
if(isset($_POST['submit'])){
    include_once("includers/timer.php");
    include_once("includers/baseQueries.php");


    $dblink = db_connect("main");


    $brand = $_POST['brand'];
    $type = $_POST['type'];
    // $serial = $_POST['serial'];
    $serial = addslashes($_POST['serial']);
    $offset = $_POST['offset'];
    $length = 10000;
    $start = tStart();
    $result=getEquipment($dblink,$brand,$type,$serial,$offset,$length);
    $count = ($length <= $result->num_rows) ? $length : $result->num_rows;
    $timing = reportTime($dblink, "equipment_production",$start , $count, "getEquipment");

    $brands = getArray($dblink,"brands");
    $types = getArray($dblink,"types");

    $showBrand = isGeneric($brand);
    $showType = isGeneric($type);

    echo "<form method='post' action='results.php'>";
    foreach ($_POST as $a => $b) {
        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
    }

    

    echo '<table>';
    echo '<tr>';
    $end = ($length > $result->num_rows) ? $offset+ $result->num_rows: $offset+$length;
    echo "<td>Showing Results $offset to $end for: </td>"; 
    echo ($showBrand) ? "<td>All Brands</td>"  : "<td>{$brands[$brand]}</td>";
    echo ($showType) ? "<td>All Types</td>" : "<td>{$types[$type]}</td>" ;
    echo '</tr>';
    echo '</table>';
    
    echo '<table>';
    echo '<tr>';
    echo "<td></td> <td>Seconds</td> <td>Rows</td> <td>Rows/second</td>"; 
    echo '</tr>';
    echo '<tr>';
    echo "<td>Current</td><td>".round($timing['newTime'],3)." </td><td>$timing[newCount] </td><td>".round($timing['newAvg'],3)." </td>"; 
    echo '</tr>';
    echo '<tr>';
    echo "<td>Overall</td><td>".round($timing['oldTime'],3)." </td><td>$timing[oldCount] </td><td>".round($timing['oldAvg'],3)." </td>"; 
    echo '</tr>';
    
    echo '</table>';


    $previous = $offset - $length;
    $next = $offset + $length;
    echo '<table>';
    echo '<tr>';
    echo "<td>Beginning</td>";
    echo ($previous < 1) ? "":"<td>Previous</td>";
    echo "<td>Current</td>";
    echo ($length > $result->num_rows) ? "":"<td>Next</td>";
    echo '</tr>';

    echo '<tr>';
    echo "<td><button name=offset value=0>0</button></td>";
    echo ($previous < 1) ? "":"<td><button name=offset value=$previous>$previous</button></td>";
    echo "<td>$offset</td>";
    echo ($length > $result->num_rows) ? "":"<td><button name=offset value=$next>$next</button></td>";
    echo '</tr>';
    echo '</table>';
    echo '</form>';

    echo '<table>';
    echo '<tr>';
    echo '<td>ID</td>';
    echo ($showType) ? '<td>Type</td>' : "";
    echo ($showBrand) ? '<td>Brand</td>' : "";
    echo '<td>Serial</td>';
    echo '<td></td></tr>';
    $count = $offset + 1;
    echo "<form method='post' action='modify.php'>";
    while ($data=$result->fetch_array(MYSQLI_ASSOC)){
        // echo "<tr>"  ;
        // echo "<td>$count</td>";
        // $count+=1;
        
        echo "<td>$data[id]</td>";

        echo ($showType) ? "<td>{$types[$data['type']]}</td>"   : "";
        echo ($showBrand) ?"<td>{$brands[$data['brand']]}</td>" : "";
        echo "<td>$data[serial]</td>";
        echo "<td><button type='submit' name='modifyDevice' value='$data[id]'>Modify</button></td>";
        echo "</tr>";
    }
    echo '</form>';
    echo '</table>';
    $dblink -> close();
} else {
    redirect("./searchMenu.php");
}