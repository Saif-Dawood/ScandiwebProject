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
 *   - length: length of the Furniture
 *   - width: width of the Furniture
 *   - height: height of the Furniture
 * 
 * Methods:
 *   - __construct(string $sku,
 *   -             string $name,
 *   -             string $price,
 *   -             array $data)
 *   - saveObj(Table $table): \mysqli_result|bool
 *   - printItem(): string
 *   - printErrors(): string
 *   - printHtml(): string
 *   - validate(): array
 *   - validateLength()
 *   - validateWidth()
 *   - validateHeight()
 */
class Furn extends Item
{
    protected $length;
    protected $width;
    protected $height;

    /**
     * Furniture Constructor
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
        if (array_key_exists('length', $data)) {
            $this->length = $data['length'];
            $this->width = $data['width'];
            $this->height = $data['height'];
            $this->dbdiff = "$this->length" . 'x' .
                "$this->width" . 'x' .
                "$this->height";
        } else
            $this->dbdiff = $data['dbdiff'];
    }

    /**
     * A function for storing the properties
     * of the Furn in the database
     * 
     * @param Table $table
     * 
     * @return \mysqli_result|bool
     * 
     * @override
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
     * 
     * @override
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
                <span>Dimensions: {$this->dbdiff}</span><br>
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
                <label for="height">Height: </label>
                <input type="text" name="height" id="height" value="{$this->height}">
                <span for="height" class="text-danger">
                    * {$this->errors['height']}
                </span>
            </div>

            <div class="attrib">
                <label for="width">Width: </label>
                <input type="text" name="width" id="width" value="{$this->width}">
                <span for="width" class="text-danger">
                    * {$this->errors['width']}
                </span>
            </div>

            <div class="attrib">
                <label for="length">Length: </label>
                <input type="text" name="length" id="length" value="{$this->length}">
                <span for="length" class="text-danger">
                    * {$this->errors['length']}
                </span>
            </div>
            <p style="font-weight:bold;">Please provide the dimensions</p>
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
                <label for="height">Height: </label>
                <input type="text" name="height" id="height" value="">
                <span for="height" class="text-danger">
                    *
                </span>
            </div>

            <div class="attrib">
                <label for="width">Width: </label>
                <input type="text" name="width" id="width" value="">
                <span for="width" class="text-danger">
                    *
                </span>
            </div>

            <div class="attrib">
                <label for="length">Length: </label>
                <input type="text" name="length" id="length" value="">
                <span for="length" class="text-danger">
                    *
                </span>
            </div>
            <p style="font-weight:bold;">Please provide the dimensions</p>
        HTML;
    }

    /**
     * A function that validates items before dealing with them
     * 
     * @return array
     */
    public function validate(): array
    {
        $this->validateLength();
        $this->validateWidth();
        $this->validateHeight();

        return $this->errors;
    }

    /**
     * Validator for Length
     *
     */
    private function validateLength()
    {
        $this->error_count++;
        if (empty($this->length)) {
            $this->errors['length'] = "Length is required";
            return;
        }

        $this->length = $this::testInput($this->length);

        if (!filter_var($this->length, FILTER_VALIDATE_FLOAT)) {
            $this->errors['length'] = "Only decimal numbers are allowed";
            return;
        }

        $this->length = (float) $this->length;

        if ($this->length <= 0)
            $this->errors['length'] = "Only positive numbers are allowed";
        else {
            $this->errors['length'] = "";
            $this->error_count--;
        }
    }

    /**
     * Validator for Width
     *
     */
    private function validateWidth()
    {
        $this->error_count++;
        if (empty($this->width)) {
            $this->errors['width'] = "Width is required";
            return;
        }

        $this->width = $this::testInput($this->width);

        if (!filter_var($this->width, FILTER_VALIDATE_FLOAT)) {
            $this->errors['width'] = "Only decimal numbers are allowed";
            return;
        }

        $this->width = (float) $this->width;

        if ($this->width <= 0)
            $this->errors['width'] = "Only positive numbers are allowed";
        else {
            $this->errors['width'] = "";
            $this->error_count--;
        }
    }

    /**
     * Validator for Height
     *
     */
    private function validateHeight()
    {
        $this->error_count++;
        if (empty($this->height)) {
            $this->errors['height'] = "Height is required";
            return;
        }

        $this->height = $this::testInput($this->height);

        if (!filter_var($this->height, FILTER_VALIDATE_FLOAT)) {
            $this->errors['height'] = "Only decimal numbers are allowed";
            return;
        }

        $this->height = (float) $this->height;

        if ($this->height <= 0)
            $this->errors['height'] = "Only positive numbers are allowed";
        else {
            $this->errors['height'] = "";
            $this->error_count--;
        }
    }
}