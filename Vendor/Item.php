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
 * 
 * Methods:
 *   - setChecked(bool $checked)
 *   - getChecked()
 *   - massDelete(Table $table, array $items)
 *   - saveObj(Table $table)
 *   - getObj(Table $table, int $sku)
 *   - printItem()
 */
abstract class Item
{
    protected $sku;
    protected $name;
    protected $price;
    protected $checked = false;
    protected $dbdiff;

    /**
     * Item constructor.
     *
     * @param string $sku
     * @param string $name
     * @param float $price
     */
    public function __construct(
        string $sku,
        string $name,
        float $price
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
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
     * Getter for checked
     * 
     * @return bool
     */
    public function getChecked(): bool
    {
        return $this->checked;
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
     * A function used for deleting
     * the checked items
     * 
     * @param Table $table
     * @param array $items
     * 
     * @return void
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

    /**
     * An abstract function for storing the properties
     * of the object in the database
     * 
     * @param Table $table
     * 
     * @return \mysqli_result|bool
     */
    public abstract function saveObj(Table $table): \mysqli_result|bool;

    /**
     * An abstract function for printing
     * the object in the form
     * 
     * @return string
     */
    public abstract function printItem(): string;

    /**
     * An abstract function for getting the
     * html for the different properties between children
     * 
     * @param array $output
     * 
     * @return string
     */
    public static abstract function printHtml(array $output): string;
}
