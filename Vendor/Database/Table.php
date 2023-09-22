<?php

namespace Vendor\Database;

use Exception;
use mysqli;

/**
 * A class for dealing with database tables
 *
 * Properties:
 *      db -> database
 *      name -> table's name
 *      cols -> an array:
 *                  key: column name
 *                  value: column types and constraints
 */
class Table
{
    private $db;
    private $name;
    private $cols;

    /**
     * Connects to the database.
     *
     * @param Database $db
     * @param string $name
     * @param array $cols
     */
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
            if ($i !== 0) {
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
    }

    /**
     * A function to get all rows of this table
     * 
     * @return \mysqli_result|bool
     */
    public function getRows(): \mysqli_result|bool
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
     * Inserts a new row into this table.
     *
     * @param array $cols_vals An array containing the column names and 
     *                         values to be inserted. Each key is the
     *                         column name and each value is the value
     *                         to be inserted.
     *
     * @return bool True if the row was successfully inserted, false otherwise.
     */
    public function addRow(array $cols_vals): bool
    {
        // Try connecting
        $conn = new mysqli();

        if (!$this->db->connectDB($conn)) {
            return false;
        }

        // Query to add row
        $sql = "INSERT INTO " . $this->name . "(";

        // Columns
        $i = 0;

        foreach ($cols_vals as $col => $val) {
            if ($i !== 0) {
                $sql .= ", ";
            }

            $sql .= $col;
            $i++;
        }

        $sql .= ") VALUES (";

        // Values
        $i = 0;

        foreach ($cols_vals as $col => $val) {
            if ($i !== 0) {
                $sql .= ", ";
            }

            if (gettype($val) === "string") {
                $sql .= "'$val'";
            } else {
                $sql .= $val;
            }

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
        return $result;
    }

    /**
     * Deletes a row from this table.
     *
     * @param string $sku The SKU of the row to be deleted.
     *
     * @return bool True if the row was successfully deleted, false otherwise.
     */
    public function delRow(string $sku): bool
    {
        // Try connecting
        $conn = new mysqli();

        if (!$this->db->connectDB($conn)) {
            return false;
        }

        // Query to delete row
        $sql = "DELETE FROM " . $this->name . " WHERE sku = '$sku'";

        // Try to delete row
        try {
            $result = $conn->query($sql);
        } catch (Exception $e) {
            $conn->close();
            return false;
        }

        // Saving the changes
        $conn->close();

        // No errors
        return $result;
    }
}