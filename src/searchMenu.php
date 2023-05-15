<!DOCTYPE html>
<html>
<?php
include_once("includers/timer.php");
include_once("includers/baseQueries.php");
$dblink = db_connect("main");
?>

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
    <title>Search Menu!</title>
</head>

<body>
    <form method='post' action='results.php'>
        <div class="mb-3">
            <label for="brand" class="form-label">Brand:</label>
            <select name='brand' class="form-select">
                <option value='all' selected>All</option>
                <?php
                $brand = getArray($dblink, "brands");
                foreach ($brand as $key => $value) {
                    echo "<option value='$key'>$value</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type:</label>
            <select name='type' class="form-select">
                <option value='all' selected>All</option>
                <?php
                $type = getArray($dblink, "types");
                foreach ($type as $key => $value) {
                    echo "<option value='$key'>$value</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="serial" class="form-label">Serial Number (Optional):</label>
            <input type="text" name="serial" class="form-control" value="">
        </div>
        <input type="hidden" name="offset" value="0">

        <button type='submit' name='submit' class="btn btn-primary" value='submit'>Submit</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>