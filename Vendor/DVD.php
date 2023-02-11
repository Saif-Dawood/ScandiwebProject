<?php

namespace Vendor;

use Vendor\Database\Table;
use Vendor\Item;

/**
 * A class for DVD-discs
 * 
 * This is a child class to the abstract class Item
 * which contains a new property (size)
 * 
 * Properties:
 *              size: size of the DVD (MB)
 * 
 * Methods:
 *              __construct(string $sku,
 *                          string $name,
 *                          float $price,
 *                          float $size)
 *              saveObj(Table $table)
 *              getObj(Table $table, int $sku)
 *              printItem()
 */
class DVD extends Item
{
    protected $size;

    public function __construct(
        string $sku,
        string $name,
        float $price,
        float $size
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->size = $size;
        $this->dbdiff = "$size";
    }

    /**
     * A function for storing the properties
     * of the DVD in the database
     */
    public function saveObj(Table $table)
    {
        $cols_vals['sku'] = $this->sku;
        $cols_vals['name'] = $this->name;
        $cols_vals['price'] = $this->price;
        $cols_vals['type'] = "DVD";
        $cols_vals['dbdiff'] = $this->dbdiff;
        return $table->addRow($cols_vals);
    }

    /**
     * A function for getting the properties
     * of a single DVD according to sku
     * 
     * Returns the corresponding object if found
     */
    public function getObj(Table $table, int $sku)
    {
        // Try to get all the rows from $table
        $rows = $table->getRows();
        if ($rows === false || $rows->num_rows === 0) {
            return false;
        }

        // Search for row with $sku
        while ($row = $rows->fetch_assoc()) {
            if ($row['sku'] === $sku) {
                break;
            }
        }

        // Not found
        if (!$row) {
            return false;
        }

        // Found
        // Assign values to this obj
        $this->sku = $row['sku'];
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->dbdiff = $row['dbdiff'];

        // No errors
        return true;
    }

    /**
     * A function to print the div containing the item
     * in index.php
     */
    public function printItem()
    {
        echo "
            <div class=\"item\">\n
                <input type=\"checkbox\" class=\"delete-checkbox\" " .
                    ($this->checked ? "checked" : "") . "><br>\n
                <label>$this->sku</label><br>\n
                <label>$this->name</label><br>\n
                <label>$this->price\$</label><br>\n
                <label>Size: $this->size KG</label><br>\n
            </div>
        ";
    }
}
