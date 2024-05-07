<?php
require "Vendor/Database/Database.php";
require "Vendor/Database/TableRow.php";
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
$cols = array();
require "table_columns.php";

// Create table if not exists
$table = new Table($db, "items", $cols);

// Get rows from table 'items'
$rows = $table->getRows();

// An array of items to access them later for MASS DELETE
$objs = array();

// Check if there are rows to loop through
if ($rows != false) {
    // Initiallize index
    $i = 0;
    $no_items = "hidden";
    $item = "";

    // Create Item object for each row
    foreach ($rows as $row) {
        // Get type
        $type = "Vendor\\" . $row->getColumnValue('type');

        // Create Item obj with TableRow $row
        $objs[$i] = new $type($row);

        // Initialize variables
        $sku = $objs[$i]->getSku();
        $name = $objs[$i]->getName();
        $price = $objs[$i]->getPrice();
        $dbdiff = $objs[$i]->getPrint_dbdiff();

        // View item on products page
        require "product.php";

        // Increment Index
        $i++;
    }
} else {
    $no_items = "";
    $item = "hidden";
    $sku = "";
    $name = "";
    $price = "";
    $dbdiff = "";
    require "product.php";
}