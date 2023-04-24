<?php

namespace Vendor\Validator;

use Vendor\Item;
use Vendor\Book;
use Vendor\DVD;
use Vendor\Furn;
use Vendor\Database\Database;
use Vendor\Database\Table;

/**
 * A Validator Class for handling the Item's data
 * before creating an object of it
 * 
 * 
 * 
 * Properties:
 *   - sku: a unique code for each item
 *   - name: item's name
 *   - price: item's price
 *   - checked: If the checkbox is checked or not
 *              for mass delete
 *   - dbdiff: A parameter for storing the different
 *              attributes in the database
 * 
 * Methods:
 *   - validate(): array
 *   - validateSKU()
 *   - validateName()
 *   - validatePrice()
 *   - validateType()
 *   - getData(): array
 *   - getErrCount(): int
 *   - static testInput(mixed $data): mixed
 */
class ItemValidator
{
    private array $data;
    private array $errors;
    private int $error_count;

    /**
     * Item Validator Constructor
     * 
     * @param array $post_data $_POST array
     */
    public function __construct(array $post_data)
    {
        $this->data = $post_data;
        $this->error_count = 0;
    }

    /**
     * A function that validates standard input before
     * creating an item
     * 
     * @return array
     */
    public function validate(): array
    {
        $this->validateSKU();
        $this->validateName();
        $this->validatePrice();
        $this->validateType();

        return $this->errors;
    }

    /**
     * Validator for SKU
     *
     */
    private function validateSKU()
    {
        $this->error_count++;
        if (empty($this->data['sku'])) {
            $this->errors['sku'] = "SKU is required";
            return;
        }

        $sku_pattern = "/^[a-zA-Z0-9-]*$/";
        $this->data['sku'] = $this::testInput($this->data['sku']);

        if (!preg_match($sku_pattern, $this->data['sku']))
            $this->errors['sku'] = "Only letters and numbers are allowed";
        else {
            $this->errors['sku'] = "";
            $this->error_count--;
        }
    }

    /**
     * Validator for Name
     *
     */
    private function validateName()
    {
        $this->error_count++;
        if (empty($this->data['name'])) {
            $this->errors['name'] = "Name is required";
            return;
        }

        $name_pattern = "/^[a-zA-Z0-9-' ]*$/";
        $this->data['name'] = $this::testInput($this->data['name']);

        if (!preg_match($name_pattern, $this->data['name']))
            $this->errors['name'] = "Only letters and whitespaces are allowed";
        else {
            $this->errors['name'] = "";
            $this->error_count--;
        }
    }

    /**
     * Validator for Price
     *
     */
    private function validatePrice()
    {
        $this->error_count++;
        if (empty($this->data['price'])) {
            $this->errors['price'] = "Price is required";
            return;
        }

        $this->data['price'] = $this::testInput($this->data['price']);

        if (!filter_var($this->data['price'], FILTER_VALIDATE_FLOAT)) {
            $this->errors['price'] = "Only decimal numbers are allowed";
            return;
        }

        $this->data['price'] = (float) $this->data['price'];

        if ($this->data['price'] <= 0)
            $this->errors['price'] = "Only positive numbers are allowed";
        else {
            $this->errors['price'] = "";
            $this->error_count--;
        }
    }

    /**
     * Validator for Type
     *
     */
    private function validateType()
    {
        $this->error_count++;
        if (empty($this->data['type'])) {
            $this->errors['type'] = "Choose a type";
            return;
        }

        $this->data['type'] = $this::testInput($this->data['type']);
        $types = array(
            "DVD",
            "Book",
            "Furn"
        );

        if (!in_array($this->data['type'], $types)) {
            $this->errors['type'] = "Don't";
            $this->data['type'] = "";
        } else {
            $this->errors['type'] = "";
            $this->data['class'] = "Vendor\\" . $this->data['type'];
            $this->error_count--;
        }
    }

    /**
     * Getter for data array after editing it
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Getter for error_count
     * 
     * @return int
     */
    public function getErrCount(): int
    {
        return $this->error_count;
    }

    /**
     * a function for refractoring inputs from harmful 
     * html characters
     *
     * @param mixed $data
     * @return mixed
     */
    private static function testInput($data): mixed
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}