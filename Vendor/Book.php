<?php

namespace Vendor;

use Vendor\Database\Table;
use Vendor\Item;

/**
 * A class for Book
 * 
 * This is a child class to the abstract class Item
 * which contains a new property (weight)
 * 
 * Properties:
 *              weight: weight of the Book (KG)
 * 
 * Methods:
 *              __construct(string $sku,
 *                          string $name,
 *                          float $price,
 *                          float $weight)
 *              saveObj(Table $table)
 *              getObj(Table $table, int $sku)
 *              printItem()
 */
class Book extends Item
{
    protected $weight;

    public function __construct(
        string $sku,
        string $name,
        float $price,
        float $weight
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->weight = $weight;
        $this->dbdiff = "$weight";
    }

    /**
     * A function for storing the properties
     * of the Book in the database
     */
    public function saveObj(Table $table)
    {
        $cols_vals['sku'] = $this->sku;
        $cols_vals['name'] = $this->name;
        $cols_vals['price'] = $this->price;
        $cols_vals['type'] = "Book";
        $cols_vals['dbdiff'] = $this->dbdiff;
        return $table->addRow($cols_vals);
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
                <label>Weight: $this->weight KG</label><br>\n
            </div>
        ";
    }
}
