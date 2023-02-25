<?php
$table['raw'] =     "CREATE TABLE `main`.`equipment_source`(
                    `type` VARCHAR(32) NOT NULL ,
                    `brand` VARCHAR(32) NOT NULL ,
                    `serial` VARCHAR(256) NOT NULL UNIQUE ) 
                    ENGINE = InnoDB;";

$table['prod'] =    "CREATE TABLE `main`.`equipment_production`(
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `type` INT NOT NULL ,
                    `brand` INT NOT NULL ,
                    `serial` VARCHAR(256) NOT NULL ,
                    PRIMARY KEY (`id`)) 
                    ENGINE = InnoDB;";

$table['brands'] =  "CREATE TABLE `main`.`brands`(
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `name` VARCHAR(32) NOT NULL ,
                    PRIMARY KEY (`id`)) 
                    ENGINE = InnoDB;";

$table['types'] =   "CREATE TABLE `main`.`types`(
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `name` INT NOT NULL ,
                    PRIMARY KEY (`id`)) 
                    ENGINE = InnoDB;";
