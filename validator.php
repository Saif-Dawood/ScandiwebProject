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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Create a TableRow obj
    $row = new TableRow();

    $row->setColumnsValue($_POST);

    $type = "Vendor\\" . $row->getColumnValue('type');

    $obj = new $type(
        $row
    );

    $data = array(
        'sku' => $obj->getSku(),
        'name' => $obj->getName(),
        'price' => $obj->getPrice(),
        'type' => $row->getColumnValue('type')
    );


    foreach ($obj::PRINT_ADD as $field) {
        $Attr .= <<<HTML
            <div class="attrib">
                <label for="{$field['lower']}">{$field['title']} ({$field['mu']}): </label>
                <input type="text" name="{$field['lower']}" class="req_field dec_field" id="{$field['lower']}" value="{$obj->getExtraValues($field['lower'])}">
                <span for="{$field['lower']}" class="text-danger" id="err_{$field['lower']}">
                    *
                </span>
            </div>
        HTML;
    }
    $Attr .= <<<HTML
        <p style="font-weight:bold;">
    HTML . $obj::PRINT_DESCRIPTION . "</p>";


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

    // Try saving the object
    if ($obj->saveObj($table)) {
        header("refresh: 0; url = index.php");
        ob_end_flush();
    } else {
        $sku_err = "This SKU was already used before";
    }
}