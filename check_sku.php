<?php

require "Vendor/Database/Database.php";
require "Vendor/Database/TableRow.php";
require "Vendor/Database/Table.php";
require "Vendor/Item.php";

use Vendor\Database\Database;
use Vendor\Database\Table;
use Vendor\Item;

ini_set('display_errors', 1);


$sku = $_POST['sku'];

// Create database if not exists
$db = new Database($_SERVER['DBNAME']);

// Define Columns
$cols['id'] = array(
    "INT(6)",
    "UNSIGNED",
    "AUTO_INCREMENT",
    "PRIMARY KEY"
);
$cols['sku'] = array("VARCHAR(12)", "UNIQUE", "NOT NULL");
$cols['name'] = array("VARCHAR(30)", "NOT NULL");
$cols['price'] = array("REAL(6,2)", "UNSIGNED", "NOT NULL");
$cols['type'] = array("VARCHAR(4)", "NOT NULL");
$cols['dbdiff'] = array("VARCHAR(30)", "NOT NULL");

// Create table if not exists
$table = new Table($db, "items", $cols);



$exists = Item::SkuExists($table, $sku);

header('Content-Type: application/json');
echo json_encode(['exists' => $exists]);