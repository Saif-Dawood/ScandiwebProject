<?php
namespace Database;

use Exception;
use mysqli;

/**
 * Globals section
 * for connecting to database
 */
$GLOBALS['$sname'] = "localhost";
$GLOBALS['$uname'] = "saif";
$GLOBALS['$pass'] = "qwer";
$GLOBALS['$db'] = "scandi";

/**
 * conn -> connection
 * sname -> server name (host name)
 * uname -> username
 * pass -> password
 * db -> database name
 */
function connectDB(mysqli &$conn)
{
    try {
        $conn = new mysqli (
            $GLOBALS['sname'],
            $GLOBALS['uname'],
            $GLOBALS['pass'],
            $GLOBALS['db']
        );
    } catch (Exception $e) {
        $conn->close();
        return false;
    }
    return true;
}