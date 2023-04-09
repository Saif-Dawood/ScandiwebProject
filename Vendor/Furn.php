<?php

namespace Vendor;

use Vendor\Database\Table;

/**
 * A class for Furniture
 * 
 * This is a child class to the abstract class Item
 * which contains a new property (dimensions)
 * 
 * Properties:
 * - dimensions: dimensions of the Furniture
 * 
 * Methods:
 * - __construct(string $sku, string $name, float $price, float $dimensions)
 * - saveObj(Table $table)
 * - getObj(Table $table, int $sku)
 * - printItem()
 */
class Furn extends Item
{
    protected $dimensions;

    /**
     * Furniture Constructor
     * 
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param string $dimensions
     */
    public function __construct(
        string $sku,
        string $name,
        float $price,
        string $dimensions
    ) {
        parent::__construct($sku, $name, $price);
        $this->dimensions = $dimensions;
        $this->dbdiff = $dimensions;
    }

    /**
     * A function for storing the properties
     * of the Furn in the database
     * 
     * @param Table $table
     * 
     * @return \mysqli_result|bool
     */
    public function saveObj(Table $table): \mysqli_result|bool
    {
        $cols_vals = [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'type' => 'Furn',
            'dbdiff' => $this->dbdiff,
        ];
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
                    <input type="checkbox" class="delete-checkbox" 
                        name="{$this->sku}"><br>
                </div>
                <span>{$this->sku}</span><br>
                <span>{$this->name}</span><br>
                <span>{$this->price}$</span><br>
                <span>Dimensions: {$this->dimensions}</span><br>
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
                <label for="height">Height: </label>
                <input type="text" name="height" id="height" value="{$output['height']}">
                <span for="height" class="text-danger">
                    * {$output['heightErr']}
                </span>
            </div>

            <div class="attrib">
                <label for="width">Width: </label>
                <input type="text" name="width" id="width" value="{$output['width']}">
                <span for="width" class="text-danger">
                    * {$output['widthErr']}
                </span>
            </div>

            <div class="attrib">
                <label for="length">Length: </label>
                <input type="text" name="length" id="length" value="{$output['length']}">
                <span for="length" class="text-danger">
                    * {$output['lengthErr']}
                </span>
            </div>
            <p style="font-weight:bold;">Please provide the dimensions</p>
        HTML;
    }
}
