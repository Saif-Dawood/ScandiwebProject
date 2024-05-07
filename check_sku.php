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
$cols = array();
require "table_columns.php";

// Create table if not exists
$table = new Table($db, "items", $cols);



$exists = Item::SkuExists($table, $sku);

header('Content-Type: application/json');
echo json_encode(['exists' => $exists]);