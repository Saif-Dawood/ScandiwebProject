<?php

namespace Vendor;

use Vendor\Database\Table;
use Vendor\Item;

/**
 * A class for Furniture
 * 
 * This is a child class to the abstract class Item
 * which contains a new property (dimensions)
 * 
 * Properties:
 *              dimensions: dimensions of the Furniture
 * 
 * Methods:
 *              __construct(string $sku,
 *                          string $name,
 *                          float $price,
 *                          float $dimensions)
 *              saveObj(Table $table)
 *              getObj(Table $table, int $sku)
 *              printItem()
 */
class Furn extends Item
{
    protected $dimensions;
    protected $height;
    protected $width;
    protected $length;

    public function __construct(
        string $sku,
        string $name,
        float $price,
        float $height,
        float $width,
        float $length
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
        $this->dimensions = "$height" . "x" . "$width" . "x" . "$length";
        $this->dbdiff = "$height" . ", " . "$width" . ", " . "$length";
    }

    /**
     * A function for storing the properties
     * of the Furn in the database
     */
    public function saveObj(Table $table)
    {
        $cols_vals['sku'] = $this->sku;
        $cols_vals['name'] = $this->name;
        $cols_vals['price'] = $this->price;
        $cols_vals['type'] = "Furn";
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
                <label>Dimensions: $this->dimensions KG</label><br>\n
            </div>
        ";
    }
}
