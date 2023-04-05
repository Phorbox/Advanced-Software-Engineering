<?php

include_once("timer.php");
include_once("baseQueries.php");

$table['log'] =  "CREATE TABLE `main`.`log` ( `id` INT NOT NULL AUTO_INCREMENT , `table` VARCHAR(64) NOT NULL , `seconds` FLOAT NOT NULL , `rows` INT NOT NULL , `timeStamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `type` VARCHAR(16) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
                ";

$table['raw'] =    "CREATE TABLE `main`.`equipment_source`(
                    `type` VARCHAR(32) NOT NULL ,
                    `brand` VARCHAR(32) NOT NULL ,
                    `serial` VARCHAR(256) NOT NULL ) 
                    ENGINE = MyISam;
                ";

$table['prod'] =   "CREATE TABLE `main`.`equipment_production`(
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `type` INT NOT NULL ,
                    `brand` INT NOT NULL ,
                    `serial` VARCHAR(256) NOT NULL ,
                    PRIMARY KEY (`id`)) 
                    ENGINE = InnoDB;
                ";

$table['brands'] = "CREATE TABLE `main`.`brands`(
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `name` VARCHAR(32) NOT NULL ,
                    PRIMARY KEY (`id`)) 
                    ENGINE = InnoDB;
                ";

$table['types'] =  "CREATE TABLE `main`.`types`(
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `name` VARCHAR(32) NOT NULL ,
                    PRIMARY KEY (`id`)) 
                    ENGINE = InnoDB;
                ";


$dblink = db_connect("main");

$TimeAllStart = tStart();
foreach ($table as $name => $sql) {
    $time_start = tStart();
    
    $dblink->query($sql) or  
        die("Something went wrong with Query: $sql<br>\n" . $dblink->error);
    
    $seconds = tTotal($time_start);
    logTime($dblink, $name, $seconds, 1, "CREATE");
} 

$secondsAll = tTotal($TimeAllStart);
logTime($dblink, "all", $secondsAll, count($table), "CREATE");
    
    
