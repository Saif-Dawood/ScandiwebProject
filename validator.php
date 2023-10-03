<?php

ob_start();

require "Vendor/Validator/ItemValidator.php";
require "Vendor/Database/Database.php";
require "Vendor/Database/Table.php";
require "Vendor/Item.php";
require "Vendor/DVD.php";
require "Vendor/Book.php";
require "Vendor/Furn.php";

use Vendor\Database\Database;
use Vendor\Database\Table;
use Vendor\Validator\ItemValidator;
use Vendor\Item;
use Vendor\DVD;
use Vendor\Book;
use Vendor\Furn;

$errors = array(
    'sku' => "",
    'name' => "",
    'price' => "",
    'type' => ""
);

$data = array(
    'sku' => "",
    'name' => "",
    'price' => "",
    'type' => ""
);

$Attr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $validator = new ItemValidator($_POST);
    $errors = $validator->validate();
    $data = array_merge($data, $validator->getData());
    $err_no = $validator->getErrCount();
    $obj;

    if (array_key_exists('class', $data)) {

        $obj = new $data['class'](
            $data['sku'],
            $data['name'],
            $data['price'],
            $data
        );

        $errors = array_merge($errors, $obj->validate());
        $err_no += $obj->getErrCount();

        $Attr = $obj->printErrors();
    }

    // check if no errors
    if ($err_no == 0) {

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
            $errors['sku'] = "This SKU was already used before";
            $err_no++;
        }
    }
}