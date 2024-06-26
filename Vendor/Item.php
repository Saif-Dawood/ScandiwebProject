<?php

namespace Vendor;

use mysqli;
use Vendor\Database\Table;
use Vendor\Database\TableRow;

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
 *             attributes in the database
 *   - print_dbdiff: An html string of the dbdiff part
 *                   to be written on the item in products page
 * 
 * Methods:
 *   - __construct(TableRow $row)
 *   - setChecked(bool $checked)
 *   - massDelete(Table $table, array $items)
 *   - SkuExists(Table $table): bool
 *   - getSku(): string
 *   - getName(): string
 *   - getPrice(): string
 *   - getPrint_dbdiff(): string
 *   - abstract saveObj(Table $table): bool
 *   - abstract getExtraValues(string $var_name): string
 */
abstract class Item
{
    protected $sku;
    protected $name;
    protected $price;
    protected $checked = false;
    protected $dbdiff;
    protected $print_dbdiff;

    /**
     * Item constructor.
     * 
     * @param TableRow $row
     */
    public function __construct(TableRow $row)
    {
        $this->sku = $row->getColumnValue('sku');
        $this->name = $row->getColumnValue('name');
        $this->price = $row->getColumnValue('price');
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

    /**
     * A function to find whether
     * a certain SKU exists in the 
     * table or not
     * 
     * @param Table $table
     * @param string $sku
     * 
     * 
     * @return bool
     */
    public static function SkuExists(Table $table, string $sku): bool
    {
        $skus = array();

        $rows = $table->getRows();

        foreach ($rows as $row) {
            if ($sku == $row->getColumnValue('sku'))
                return true;
        }

        return false;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getPrint_dbdiff(): string
    {
        return $this->print_dbdiff;
    }

    /**
     * An abstract function for storing the properties
     * of the object in the database
     * 
     * @param Table $table
     * 
     * @return bool
     */
    public abstract function saveObj(Table $table): bool;
}