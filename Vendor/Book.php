<?php

namespace Vendor;

use Vendor\Database\Table;

/**
 * A class for Book.
 *
 * This is a child class to the abstract class Item
 * which contains a new property (weight).
 */
class Book extends Item
{
    protected float $weight;

    /**
     * Book Constructor
     *
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param float $weight
     */
    public function __construct(
        string $sku,
        string $name,
        float $price,
        float $weight
    ) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
        $this->dbdiff = "$weight";
    }

    /**
     * A function for storing the properties
     * of the Book in the database.
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
            'type' => "Book",
            'dbdiff' => $this->dbdiff
        ];
        return $table->addRow($cols_vals);
    }

    /**
     * A function to print the div containing the item
     * in index.php.
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
                <span>Weight: {$this->weight} KG</span><br>
            </div>
        HTML;
    }


    /**
     * A function for getting the
     * html for the different properties.
     *
     * @param array $output
     * 
     * @return string
     */
    public static function printHtml(array $output): string
    {
        return <<<HTML
            <div class="attrib">
                <label for="weight">Weight (KG): </label>
                <input type="text" name="weight" id="weight" value="{$output['weight']}">
                <span for="weight" class="text-danger">
                    * {$output['weightErr']}
                </span>
            </div>
            <p style="font-weight:bold;">Please provide the weight of the book</p>
        HTML;
    }
}
