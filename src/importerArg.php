<?php
include_once("timer.php");
include_once("baseQueries.php");
include_once("importer.php");
// echo("hi");
echo "Hello from php process $argv[1] about to process file:$argv[2]\n";
import($argv[2]);
