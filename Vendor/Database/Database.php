<?php

namespace Vendor\Database;

use Exception;
use mysqli;

/**
 * A class for dealing with databases
 * BUT with a constant host name, username, and password
 * 
 * 
 * 
 * Properties:
 *   - SNAME: Servername (constant)
 *   - UNAME: Username (constant)
 *   - PASS: Password (constant)
 *   - db: Database name
 * 
 * Methods:
 *   - connectDB(mysqli &$conn): bool
 */
class Database
{
    private const SNAME = "localhost";
    private const UNAME = "id20649662_saif";
    private const PASS = "wKF8rZ1VS8@G(&gTePop";
    private $db;

    /**
     * Creates a database if not exists with name "$db"
     *
     * @param string $db The database name
     */
    public function __construct(string $db)
    {
        $this->db = $db;

        // Connecting without a database
        try {
            $conn = new mysqli(
                self::SNAME,
                self::UNAME,
                self::PASS
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

        // Saving the changes
        $conn->close();
    }

    /**
     * Connects to the database.
     *
     * @param mysqli $conn The connection object passed by reference.
     *
     * @return bool True if the connection is successful, false otherwise.
     */
    public function connectDB(mysqli &$conn): bool
    {
        try {
            $conn = new mysqli(
                self::SNAME,
                self::UNAME,
                self::PASS,
                $this->db
            );
        } catch (Exception $e) {
            $conn->close();
            return false;
        }

        return true;
    }
}