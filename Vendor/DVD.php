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
                <span>Size: $this->size MB</span><br>\n
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
                <label for=\"size\">Size (MB): </label>\n
                <input type=\"text\" name=\"size\" id=\"size\">\n
                <span for=\"size\" class=\"text-danger\">\n
                    *
                </span>\n
            </div>\n
        ";
    }
}
