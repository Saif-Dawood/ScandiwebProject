<?php

namespace Vendor\Database;

use Exception;
use mysqli;

/**
 * A class for dealing with databases
 * BUT with a constant host name, username, and password
 */
class Database
{
    private $sname = "localhost";
    private $uname = "saif";
    private $pass = "qwer";
    private $db;

    public function __construct(string $db)
    {
        $this->db = $db;
        // Connecting without a database
        try {
            $conn = new mysqli(
                $this->sname,
                $this->uname,
                $this->pass
            );
        } catch (Exception $e) {
            return;
        }

        // Query to create the database
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->db;

        // Creating a new database if it doesn't exist already
        try {
            $conn->query($sql);
        } catch (Exception $e) {
            $conn->close();
            return;
        }

        // saving the changes
        $conn->close();

        // No errors
        return;
    }

    /**
     * conn -> connection
     * sname -> server name (host name)
     * uname -> username
     * pass -> password
     * db -> database name
     */
    public function connectDB(mysqli &$conn)
    {
        try {
            $conn = new mysqli(
                $this->sname,
                $this->uname,
                $this->pass,
                $this->db
            );
        } catch (Exception $e) {
            $conn->close();
            return false;
        }
        return true;
    }
}
