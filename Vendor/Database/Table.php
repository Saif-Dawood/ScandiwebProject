<?php

namespace Vendor\Database;

use Exception;
use mysqli;

/**
 * A class for dealing with database Tables
 * 
 * Properties:
 *      db -> database
 *      name -> table's name
 *      cols -> an array:
 *                  key: column name
 *                  value: column types and constrains
 */
class Table
{
    private $db;
    private $name;
    private $cols;

    public function __construct(Database $db, string $name, array $cols)
    {
        $this->db = $db;
        $this->name = $name;
        $this->cols = $cols;
        $conn = new mysqli();

        if ($this->db->connectDB($conn) === false) {
            return;
        }

        // Query to create the table
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->name . " (";
        $i = 0;
        foreach ($this->cols as $col => $conds) {
            if ($i != 0) {
                $sql .= ", ";
            }
            $sql .= $col;
            foreach ($conds as $cond) {
                $sql .= " " . $cond;
            }
            $i++;
        }
        $sql .= ")";

        // Creating the table if it doesn't actually exist
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
     * A function to get all rows of this table
     */
    public function getRows()
    {
        // Try connecting
        $conn = new mysqli();
        if ($this->db->connectDB($conn) === false) {
            return false;
        }

        // Query for getting the rows
        $sql = "SELECT * FROM " . $this->name;

        // Try to get rows
        try {
            $result = $conn->query($sql);
        } catch (Exception $e) {
            $conn->close();
            return false;
        }

        // close connection
        $conn->close();

        // Return rows
        return $result;
    }

    /**
     * a function to insert a new row into this table
     * 
     * cols_vals -> an array:
     *                  key: column name
     *                  value: value to be inserted
     */
    public function addRow(array $cols_vals)
    {
        // Try connecting
        $conn = new mysqli();
        if ($this->db->connectDB($conn) === false) {
            return false;
        }

        // Query to add row
        $sql = "INSERT INTO " . $this->name . "(";
        // Columns
        $i = 0;
        foreach ($cols_vals as $col => $val) {
            if ($i != 0) {
                $sql .= ", ";
            }
            $sql .= $col;
            $i++;
        }
        $sql .= ") VALUES (";
        // Values
        $i = 0;
        foreach ($cols_vals as $col => $val) {
            if ($i != 0) {
                $sql .= ", ";
            }
            $sql .= $val;
            $i++;
        }
        $sql .= ")";

        // Try to add row
        try {
            $result = $conn->query($sql);
        } catch (Exception $e) {
            $conn->close();
            return false;
        }

        // Saving the changes
        $conn->close();

        // No errors
        return true;
    }
}
