<?php

require("./includers/config.php");

if (isset($_POST['submit'])) {
    include_once(DIR_INCLUDERS . "timer.php");
    include_once(DIR_INCLUDERS . "baseQueries.php");

    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $serial = $_POST['serial'];
    $offset = $_POST['offset'];
    $length = 1000;

    $ch = curl_init();
    $url = URL . "api/results?brand=$brand&type=$type&serial=$serial&offset=$offset";
    // echo $url;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    $err = curl_error($ch);
    if ($err) {
        echo "cURL Error #:" . $err;
    }
    // Closing
    curl_close($ch);
    // echo $result;
    $json = json_decode($result, true);
    // echo $json;



    $devices = $json['data']['results'];
    // print_r($devices);
    $count = ($length <= sizeof($devices)) ? $length : sizeof($devices);
    $timing = $json['timing'];


    $showBrand = isGeneric($brand);
    $showType = isGeneric($type);

    echo "<form method='post' action='resultsApi.php'>";
    foreach ($_POST as $a => $b) {
        echo '<input type="hidden" name="' . htmlentities($a) . '" value="' . htmlentities($b) . '">';
    }



    echo '<table>';
    echo '<tr>';
    $end = ($length > sizeof($devices)) ? $offset + sizeof($devices) : $offset + $length;
    echo "<td>Showing Results $offset to $end for: </td>";
    echo ($showBrand) ? "<td>All Brands</td>"  : "<td>$brand</td>";
    echo ($showType) ? "<td>All Types</td>" : "<td>$type</td>";
    echo '</tr>';
    echo '</table>';

    echo '<table>';
    echo '<tr>';
    echo "<td></td> <td>Seconds</td> <td>Rows</td> <td>Rows/second</td>";
    echo '</tr>';
    echo '<tr>';
    echo "<td>Current</td><td>" . round($timing['newTime'], 3) . " </td><td>$timing[newCount] </td><td>" . round($timing['newAvg'], 3) . " </td>";
    echo '</tr>';
    echo '<tr>';
    echo "<td>Overall</td><td>" . round($timing['oldTime'], 3) . " </td><td>$timing[oldCount] </td><td>" . round($timing['oldAvg'], 3) . " </td>";
    echo '</tr>';
    echo '</table>';


    $previous = $offset - $length;
    $next = $offset + $length;
    echo '<table>';
    echo '<tr>';
    echo "<td>Beginning</td>";
    echo ($previous < 1) ? "" : "<td>Previous</td>";
    echo "<td>Current</td>";
    echo ($length > sizeof($devices)) ? "" : "<td>Next</td>";
    echo '</tr>';

    echo '<tr>';
    echo "<td><button name=offset value=0>0</button></td>";
    echo ($previous < 1) ? "" : "<td><button name=offset value=$previous>$previous</button></td>";
    echo "<td>$offset</td>";
    echo ($length > sizeof($devices)) ? "" : "<td><button name=offset value=$next>$next</button></td>";
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
    echo "<form method='post' action='modifyApi.php'>";
    foreach ($devices as $key => $value) {
        echo "<td>$value[id]</td>";
        echo ($showType) ? "<td>{$value['type']}</td>"   : "";
        echo ($showBrand) ? "<td>{$value['brand']}</td>" : "";
        echo "<td>$value[serial]</td>";
        echo "<td><button type='submit' name='modifyDevice' value='$value[id]'>Modify</button></td>";
        echo "</tr>";
    }
    echo '</form>';
    echo '</table>';
} else {
    include_once(DIR_INCLUDERS . "function.php");
    redirect("./searchMenuApi.php");
}
