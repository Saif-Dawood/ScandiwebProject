<?php
require "CrtDB.php";

// Connecting to the database
try {
    $conn = new mysqli (
        $GLOBALS['$sname'],
        $GLOBALS['$uname'],
        $GLOBALS['$pass'],
        $GLOBALS['$db']
    );
} catch (Exception $e) {
    die (
        "Connection to created database failed: " . 
        $e->getMessage()
    );
}

// Query to create the table
$sql = "CREATE TABLE IF NOT EXISTS items (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        sku VARCHAR(12) NOT NULL,
        name VARCHAR(30) NOT NULL,
        price REAL(6,2) UNSIGNED NOT NULL ,
        checked TINYINT(2) DEFAULT 0,
        type VARCHAR(4) NOT NULL,
        size INT(6) UNSIGNED,
        weight REAL(3,2) UNSIGNED,
        dimensions VARCHAR(14)
    )";

// Creating the table if it doesn't actually exist
try {
    $conn->query($sql);
} catch (Exception $e) {
    die("Table creatin failed: " . $e->getMessage());
}

// saving the changes
$conn->close();