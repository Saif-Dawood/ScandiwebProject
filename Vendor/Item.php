<?php

namespace Vendor;

use mysqli;
use Vendor\Database\Table;

/**
 * A class for all the items
 * 
 * This is an abstract parent class for any type of item
 * and types are going to be its children
 * 
 * Properties:
 *   - sku: a unique code for each item
 *   - name: item's name
 *   - price: item's price
 *   - checked: If the checkbox is checked or not
 *              for mass delete
 *   - dbdiff: A parameter for storing the different
 *              attributes in the database
 *   - errors: an array of errors after validation
 *   - error_count: The no of errors found
 * 
 * Methods:
 *   - __construct(string $sku,
 *                 string $name,
 *                 string $price)
 *   - setChecked(bool $checked)
 *   - getSku(): string
 *   - getErrCount(): int
 *   - massDelete(Table $table, array $items)
 *   - static testInput($data)
 *   - abstract saveObj(Table $table)
 *   - abstract printItem(): string;
 *   - abstract printErrors(): string;
 *   - abstract printHtml(): string;
 */
abstract class Item
{
    protected $sku;
    protected $name;
    protected $price;
    protected $checked = false;
    protected $dbdiff;
    protected $print_dbdiff;
    protected $errors = array();
    protected $error_count;

    /**
     * Item constructor.
     *
     * @param string $sku
     * @param string $name
     * @param string $price
     */
    public function __construct(
        string $sku,
        string $name,
        string $price
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->error_count = 0;
    }

    /**
     * Setter for checked
     * 
     * @param bool $checked
     */
    public function setChecked(bool $checked): void
    {
        $this->checked = $checked;
    }

    /**
     * Getter for sku
     * 
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
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
     * A function used for deleting
     * the checked items
     * 
     * @param Table $table
     * @param array $items
     */
    public static function massDelete(Table $table, array $items): void
    {
        foreach ($items as $item) {
            if ($item->checked) {
                if (!$table->delRow($item->sku)) {
                    echo "failed";
                }
            }
        }
    }

    protected static function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

	/**
	 * @return array
	 */
	public function getErrors(): array {
		return $this->errors;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getPrice(): string {
		return $this->price;
	}

	/**
	 * @return string
	 */
	public function getPrint_dbdiff(): string {
		return $this->print_dbdiff;
	}

    /**
     * An abstract function for storing the properties
     * of the object in the database
     * 
     * @param Table $table
     * 
     * @return
     */
    public abstract function saveObj(Table $table);

    /**
     * An abstract function for printing
     * the object in the form
     * 
     * @return string
     */
    public abstract function printItem(): string;

    /**
     * An abstract function for getting the
     * html for the different fields of the childs
     * 
     * @return string
     */
    public abstract function printErrors(): string;

    /**
     * An abstract function for getting the
     * extra values of the child classes
     * 
     * @return string
     */
    public abstract function getExtraValues(string $var_name): string;

    /**
     * An abstract function for getting the
     * html for the different fields of the childs
     * 
     * @return string
     */
    public static abstract function printHtml(): string;
}