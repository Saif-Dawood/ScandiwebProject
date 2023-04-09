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
 *     size: size of the DVD (MB)
 *
 * Methods:
 *     __construct(string $sku,
 *                 string $name,
 *                 float $price,
 *                 float $size)
 *     saveObj(Table $table)
 *     getObj(Table $table, int $sku)
 *     printItem()
 */
class DVD extends Item
{
    protected $size;

    /**
     * DVD Constructor
     * 
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param float $size
     */
    public function __construct(
        string $sku,
        string $name,
        float $price,
        float $size
    ) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
        $this->dbdiff = "$size";
    }

    /**
     * A function for storing the properties
     * of the DVD in the database
     * 
     * @param Table $table
     * 
     * @return \mysqli_result|bool
     */
    public function saveObj(Table $table): \mysqli_result|bool
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
     * 
     * @return string
     */
    public function printItem(): string
    {
        return <<<HTML
            <div class="item">
                <div class="checkdiv">
                    <input type="checkbox" class="delete-checkbox" name="{$this->sku}"><br>
                </div>
                <span>{$this->sku}</span><br>
                <span>{$this->name}</span><br>
                <span>{$this->price}\$</span><br>
                <span>Size: {$this->size} MB</span><br>
            </div>
        HTML;
    }
    

    /**
     * A function for getting the
     * html for the different properties
     * 
     * @param array $output
     * 
     * @return string
     */
    public static function printHtml(array $output): string
    {
        return <<<HTML
            <div class="attrib">
                <label for="size">Size (MB): </label>
                <input type="text" name="size" id="size" value="{$output['size']}">
                <span for="size" class="text-danger">
                    * {$output['sizeErr']}
                </span>
            </div>
            <p style="font-weight:bold;">Please provide the size of the disc</p>
        HTML;
    }
}
