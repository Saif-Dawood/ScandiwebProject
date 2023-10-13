<?php

namespace Vendor;

use Vendor\Database\Table;

/**
 * A class for Book.
 *
 * This is a child class to the abstract class Item
 * 
 * 
 * 
 * Properties:
 *   - weight: weight of the book in (KG)
 * 
 * Methods:
 *   - __construct(string $sku,
 *                 string $name,
 *                 string $price,
 *                 array $data)
 *   - saveObj(Table $table)
 *   - printItem(): string
 *   - printErrors(): string
 *   - printHtml(): string
 *   - validate(): array
 *   - validateWeight()
 */
class Book extends Item
{
    protected $weight;

    /**
     * Book Constructor
     *
     * @param string $sku
     * @param string $name
     * @param string $price
     * @param array $data
     * 
     * @override
     */
    public function __construct(
        string $sku,
        string $name,
        string $price,
        array $data
    ) {
        parent::__construct($sku, $name, $price);
        if (array_key_exists('weight', $data))
            $this->weight = $data['weight'];
        else if (array_key_exists('dbdiff', $data))
            $this->weight = $data['dbdiff'];
        else
            $this->weight = "";
        $this->dbdiff = $this->weight;
        $this->print_item = "Weight: {$this->weight} KG";
        $this->print_add = array(
            array('lower' => 'weight', 'title' => 'Weight', 'mu' => ' (KG)')
        );
        $this->print_description = "Please provide the weight of the book";
    }

    /**
     * A function for storing the properties
     * of the Book in the database.
     *
     * @param Table $table
     *
     * @return
     * 
     * @override
     */
    public function saveObj(Table $table)
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
     * 
     * @override
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
     * @return string
     * 
     * @override
     */
    public function printErrors(): string
    {
        return <<<HTML
            <div class="attrib">
                <label for="weight">Weight (KG): </label>
                <input type="text" name="weight" id="weight" value="{$this->weight}">
                <span for="weight" class="text-danger">
                    * {$this->errors['weight']}
                </span>
            </div>
            <p style="font-weight:bold;">Please provide the weight of the book</p>
        HTML;
    }

    /**
     * A function for getting the
     * html for the different fields of the childs
     * 
     * @return string
     */
    public static function printHtml(): string
    {
        return <<<HTML
            <div class="attrib">
                <label for="weight">Weight (KG): </label>
                <input type="text" name="weight" id="weight" value="">
                <span for="weight" class="text-danger">
                    *
                </span>
            </div>
            <p style="font-weight:bold;">Please provide the weight of the book</p>
        HTML;
    }

    /**
     * A function that validates items before dealing with them
     * 
     * @return array
     */
    public function validate(): array
    {
        $this->validateWeight();

        return $this->errors;
    }

    /**
     * Validator for Weight
     *
     */
    private function validateWeight()
    {
        $this->error_count++;
        if (empty($this->weight)) {
            $this->errors['weight'] = "Weight is required";
            return;
        }

        $this->weight = $this::testInput($this->weight);

        if (!filter_var($this->weight, FILTER_VALIDATE_FLOAT)) {
            $this->errors['weight'] = "Only decimal numbers are allowed";
            return;
        }

        $this->weight = (float) $this->weight;

        if ($this->weight <= 0)
            $this->errors['weight'] = "Only positive numbers are allowed";
        else {
            $this->errors['weight'] = "";
            $this->error_count--;
        }
    }
}