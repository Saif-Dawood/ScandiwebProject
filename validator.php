<?php

ob_start();

require "Vendor/Database/Database.php";
require "Vendor/Database/TableRow.php";
require "Vendor/Database/Table.php";
require "Vendor/Item.php";
require "Vendor/DVD.php";
require "Vendor/Book.php";
require "Vendor/Furn.php";

use Vendor\Database\Database;
use Vendor\Database\Table;
use Vendor\Database\TableRow;
use Vendor\Item;
use Vendor\DVD;
use Vendor\Book;
use Vendor\Furn;

$sku_err = "";

$data = array(
    'sku' => "",
    'name' => "",
    'price' => "",
    'type' => ""
);

$Attr = "";


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


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Create a TableRow obj
    $row = new TableRow();

    // Add $_POST data to the row obj 
    $row->setColumnsValue($_POST);

    $type = "Vendor\\" . $row->getColumnValue('type');

    // Create an Item obj
    $obj = new $type($row);


    // Try saving the object
    if ($obj->saveObj($table)) {
        header("refresh: 0; url = index.php");
        ob_end_flush();
    } else {
        $sku_err = "* Error while saving item";
    }
}