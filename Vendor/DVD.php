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
 *   - size: size of the DVD (MB)
 *
 * Methods:
 *   - __construct(string $sku,
 *   -             string $name,
 *   -             string $price,
 *   -             array $data)
 *   - saveObj(Table $table)
 *   - printItem(): string
 *   - printErrors(): string
 *   - printHtml(): string
 *   - validate(): array
 *   - validateSize()
 */
class DVD extends Item
{
    protected $size;

    /**
     * DVD Constructor
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
        if (array_key_exists('size', $data))
            $this->size = $data['size'];
        else if (array_key_exists('dbdiff', $data))
            $this->size = $data['dbdiff'];
        else
            $this->size = "";
        $this->dbdiff = $this->size;
        $this->print_item = "Size: {$this->size} MB";
        $this->print_add = array(
            array('lower' => 'size', 'title' => 'Size', 'mu' => ' (MB)')
        );
        $this->print_description = "Please provide the size of the disc";
    }

    /**
     * A function for storing the properties
     * of the DVD in the database
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
            'type' => "DVD",
            'dbdiff' => $this->dbdiff
        ];
        return $table->addRow($cols_vals);
    }

    /**
     * A function to print the div containing the item
     * in index.php
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
                <span>Size: {$this->size} MB</span><br>
            </div>
        HTML;
    }


    /**
     * A function for getting the
     * html for the different properties
     * 
     * @return string
     * 
     * @override
     */
    public function printErrors(): string
    {
        return <<<HTML
            <div class="attrib">
                <label for="size">Size (MB): </label>
                <input type="text" name="size" id="size" value="{$this->size}">
                <span for="size" class="text-danger">
                    * {$this->errors['size']}
                </span>
            </div>
            <p style="font-weight:bold;">Please provide the size of the disc</p>
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
                <label for="size">Size (MB): </label>
                <input type="text" name="size" id="size" value="">
                <span for="size" class="text-danger">
                    *
                </span>
            </div>
            <p style="font-weight:bold;">Please provide the size of the disc</p>
        HTML;
    }

    /**
     * A function that validates items before dealing with them
     * 
     * @return array
     */
    public function validate(): array
    {
        $this->validateSize();

        return $this->errors;
    }

    /**
     * Validator for Size
     *
     */
    private function validateSize()
    {
        $this->error_count++;
        if (empty($this->size)) {
            $this->errors['size'] = "Size is required";
            return;
        }

        $this->size = $this::testInput($this->size);

        if (!filter_var($this->size, FILTER_VALIDATE_FLOAT)) {
            $this->errors['size'] = "Only decimal numbers are allowed";
            return;
        }

        $this->size = (float) $this->size;

        if ($this->size <= 0)
            $this->errors['size'] = "Only positive numbers are allowed";
        else {
            $this->errors['size'] = "";
            $this->error_count--;
        }
    }
}