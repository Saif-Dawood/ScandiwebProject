<?php
require "Vendor/Database/Database.php";
require "Vendor/Database/Table.php";
require "Vendor/Item.php";
require "Vendor/DVD.php";
require "Vendor/Book.php";
require "Vendor/Furn.php";

use Vendor\Database\Database;
use Vendor\Database\Table;
use Vendor\DVD;
use Vendor\Book;
use Vendor\Furn;

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

// Get rows from table 'items'
$rows = $table->getRows();

// An array of items to access them later for MASS DELETE
$objs = array();

// Check if there are rows to loop through
if ($rows != false && $rows->num_rows != 0) {
    $i = 0;
    while ($row = $rows->fetch_assoc()) {
        $type = "Vendor\\" . $row['type'];
        $objs[$i] = new $type(
            $row['sku'],
            $row['name'],
            $row['price'],
            $row
        );
        echo <<<HTML
            <div class="item">
                <div class="checkdiv">
                    <input type="checkbox" class="delete-checkbox" name="{$objs[$i]->getSku()}"><br>
                </div>
                <span>{$objs[$i]->getSku()}</span><br>
                <span>{$objs[$i]->getName()}</span><br>
                <span>{$objs[$i]->getPrice()}\$</span><br>
                <span>{$objs[$i]->getPrint_dbdiff()}</span><br>
            </div>
        HTML;
        $i++;
    }
} else {
    echo "<h2>
        No items found in the database</h2>";
}