<?php

namespace Vendor\Database;

use Exception;
use mysqli;

/**
 * A class for dealing with database tables
 *
 * 
 * Properties:
 *   - db: Database
 *   - name: Table Name
 *   - cols: an array:
 *                  key: column name
 *                  value: column types and constraints
 * 
 * Methods:
 *   - __construct(Database $db,
 *                 string $name,
 *                 array $cols)
 *   - getRows(): array|bool
 *   - addRow(TableRow $row): bool
 *   - delRow(string $sku): bool
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
     * @return array[TableRow]
     */
    public function getRows(): array|bool
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
            $rows = $conn->query($sql);
        } catch (Exception $e) {
            $conn->close();
            return false;
        }

        // Create an array of TableRows
        $result = array();

        // Check if there are rows to loop through
        if ($rows != false && $rows->num_rows != 0) {
            // Initiallize index
            $i = 0;

            // Get values
            while ($row = $rows->fetch_assoc()) {
                // Create a new TableRow obj
                $tableRow = new TableRow();

                $tableRow->setColumnsValue($row);

                // Add TableRow to $result array
                $result[$i] = $tableRow;

                // Increment index
                $i++;
            }

        } else {
            $result = false;
        }

        // close connection
        $conn->close();

        // Return rows
        return $result;
    }

    /**
     * Inserts a new row into this table.
     *
     * @param TableRow $row A TableRow containing the column names and 
     *                         values to be inserted. Each key is the
     *                         column name and each value is the value
     *                         to be inserted.
     *
     * @return bool True if the row was successfully inserted, false otherwise.
     */
    public function addRow(TableRow $row): bool
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

        foreach ($this->cols as $col => $_) {
            // Check whether that column has a value to be added
            if (!$row->getColumnValue($col)) {
                continue;
            }

            if ($i !== 0) {
                $sql .= ", ";
            }

            $sql .= $col;
            $i++;
        }

        $sql .= ") VALUES (";

        // Values
        $i = 0;

        foreach ($this->cols as $col => $_) {
            $val = $row->getColumnValue($col);

            // Check whether that column has a value to be added
            if (!$val) {
                continue;
            }

            if ($i !== 0) {
                $sql .= ", ";
            }

            // Check if it is a string or not
            // to add quotations on it
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