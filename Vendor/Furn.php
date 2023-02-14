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

    public function __construct(
        string $sku,
        string $name,
        float $price,
        string $dimensions
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->dimensions = $dimensions;
        $this->dbdiff = $dimensions;
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
                <input type=\"checkbox\" class=\"delete-checkbox\" 
                    name=\"$this->sku\"><br>\n
                <span>$this->sku</span><br>\n
                <span>$this->name</span><br>\n
                <span>$this->price\$</span><br>\n
                <span>Dimensions: $this->dimensions</span><br>\n
            </div>
        ";
    }

    /**
     * A function for getting the
     * html for the different properties
     */
    public static function printHtml()
    {
        echo "
            <div>\n
                <label for=\"height\">Height: </label>\n
                <input type=\"text\" name=\"height\" id=\"height\">\n
                <span for=\"height\" class=\"text-danger\">\n
                    *
                </span>\n
            </div>\n

            <div>\n
                <label for=\"width\">Width: </label>\n
                <input type=\"text\" name=\"width\" id=\"width\">\n
                <span for=\"width\" class=\"text-danger\">\n
                    *
                </span>\n
            </div>\n

            <div>\n
                <label for=\"length\">Length: </label>\n
                <input type=\"text\" name=\"length\" id=\"length\">\n
                <span for=\"length\" class=\"text-danger\">\n
                    *
                </span>\n
            </div>\n
        ";
    }
}
