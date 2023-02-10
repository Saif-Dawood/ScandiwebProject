<?php
require "DBFunc.php";

use mysqli;
use Exception;

// Connecting without a database
try {
    $conn = new mysqli (
        $GLOBALS['$sname'],
        $GLOBALS['$uname'],
        $GLOBALS['$pass']
    );
} catch (Exception $e) {
    die("Connection failed " . $e->getMessage());
}

// Query to create the database
$sql = "CREATE DATABASE IF NOT EXISTS scandi";    

// Creating a new database if it doesn't exist already
try {
    $conn->query($sql);
} catch (Exception $e) {
    die("Error while creating database: " . $e->getMessage());
}

// saving the changes
$conn->close();