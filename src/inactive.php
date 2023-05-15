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
    <title>Results!</title>
</head>

<body>

    <?php

    include_once("includers/timer.php");
    include_once("includers/baseQueries.php");

    $dblink = db_connect("main");

    $start = tStart();
    $brands = getArray($dblink, "brands");
    $count = count($brands);
    $timing = reportTime($dblink, "brands", $start, $count, "listBrands");
    ?>

    <div class="container text-center">
        <div class="row align-items-start">
            <div class="col">
                <form method='post' action='modify.php'>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>Seconds</th>
                                <th>Rows</th>
                                <th>Rows/second</th>
                            </tr>
                            <tr>
                                <?php
                                echo "<td>Current</td><td>" . round($timing['newTime'], 3) . " </td><td>$timing[newCount] </td><td>" . round($timing['newAvg'], 3) . " </td>";
                                echo '</tr>';
                                echo '<tr>';
                                echo "<td>Overall</td><td>" . round($timing['oldTime'], 3) . " </td><td>$timing[oldCount] </td><td>" . round($timing['oldAvg'], 3) . " </td>";
                                ?>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Brand Name</th>
                                <th></th>

                            <tr>
                                <?php
                                foreach ($brands as $id => $brand) {
                                    echo '<tr>';
                                    echo "<td>$id</td>";
                                    echo "<td>$brand</td>";
                                    echo "<td><button type='submit' name='modifyBrand' value='$id'>Modify</button></td>";
                                    echo '</tr>';
                                }
                                ?>

                        </table>
                    </div>
                </form>
            </div>

            <div class="col">
                <form method='post' action='modify.php'>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>Seconds</th>
                                <th>Rows</th>
                                <th>Rows/second</th>
                            </tr>
                            <tr>
                                <?php
                                $start = tStart();
                                $types = getArray($dblink, "types");
                                $count = count($types);
                                $timing = reportTime($dblink, "types", $start, $count, "listTypes");
                                echo "<td>Current</td>";
                                echo "<td>" . round($timing['newTime'], 3) . " </td>";
                                echo "<td>$timing[newCount] </td>";
                                echo "<td>" . round($timing['newAvg'], 3) . " </td>";
                                ?>
                            </tr>
                            <tr>
                                <?php
                                echo "<td>Overall</td>";
                                echo "<td>" . round($timing['oldTime'], 3) . " </td>";
                                echo "<td>$timing[oldCount] </td>";
                                echo "<td>" . round($timing['oldAvg'], 3) . " </td>";
                                ?>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Type Name</th>
                                <th></th>
                            <tr>
                                <?php
                                foreach ($types as $id => $type) {
                                    echo '<tr>';
                                    echo "<td>$id</td>";
                                    echo "<td>$type</td>";
                                    echo "<td><button type='submit' name='modifyType' value='$id'>Modify</button></td>";
                                    echo '</tr>';
                                }
                                ?>
                        </table>
                    </div>
                </form>
                <?php
                $start = tStart();
                $inactives = getInactiveArray($dblink);
                $count = count($inactives);
                $timing = reportTime($dblink, "inactives", $start, $count, "listInactives");
                ?>
            </div>
            <div class="col">
                <form method='post' action='modify.php'>
                    <div class="table-responsive">
                        <table s class="table">
                            <tr>
                                <th></th>
                                <th>Seconds</th>
                                <th>Rows</th>
                                <th>Rows/second</th>
                            </tr>
                            <tr>
                                <td>Current</td>
                                <?php
                                echo "<td>" . round($timing['newTime'], 3) . " </td>";
                                echo "<td>$timing[newCount] </td>";
                                echo "<td>" . round($timing['newAvg'], 3) . " </td>";
                                ?>
                            </tr>
                            <tr>
                                <td>Overall</td>
                                <?php
                                echo "<td>" . round($timing['oldTime'], 3) . " </td>";
                                echo "<td>$timing[oldCount] </td>";
                                echo "<td>" . round($timing['oldAvg'], 3) . " </td>";
                                ?>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Table</th>
                                <th>Key</th>
                                <th>Name</th>
                                <th></th>
                            <tr>
                                <?php
                                foreach ($inactives as $id => $inactive) {
                                    echo '<tr>';
                                    echo "<td>$id</td>";
                                    echo "<td>$inactive[table]</td>";
                                    echo "<td>$inactive[key]</td>";
                                    echo "<td>$inactive[name]</td>";
                                    echo "<td><button type='submit' name='modifyInactive' value='$id'>Modify</button></td>";
                                    echo '</tr>';
                                }
                                ?>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>