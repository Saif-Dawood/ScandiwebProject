<?php
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
