<?php
include_once("includers/timer.php");
include_once("includers/baseQueries.php");
include_once("includers/importer.php");

echo "Hello from php process $argv[1] about to process file:$argv[2]\n";
importN($argv[2],500000/2+100);

// echo "Hello from php process 1 about to process file:equipent\n";
// importN("../data/equipment.txt",2048599);
