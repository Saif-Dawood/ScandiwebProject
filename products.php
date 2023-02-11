<?php

use Vendor\Database\Database;
use Vendor\Database\Table;
use Vendor\DVD;
use Vendor\Book;
use Vendor\Furn;

// Create database if not exists
$db = new Database("scandi");

// Define Columns
$cols['id'] = array(
    "INT(6)", "UNSIGNED", "AUTO_INCREMENT",
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
        eval(
            " \$objs[$i] = new " . $row['type'] . "(" . 
            $row['sku'] . ", " .
            $row['name'] . ", " .
            $row['price'] . ", " .
            $row['dbdiff'] . ");"
        );
        $objs[$i]->printItem();
        $i++;
    }
}