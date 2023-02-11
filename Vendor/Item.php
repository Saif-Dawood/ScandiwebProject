<?php

namespace Vendor;

use mysqli;
use Vendor\Database\Table;

/**
 * A class for all the items
 * 
 * This is an abstract parent class for any type of item
 * and types are going to be its childs
 * 
 * Properties:
 *              sku: a unique code for each item
 *              name: item's name
 *              price: item's price
 *              checked: If the checkbox is checked or not
 *                       for mass delete
 * 
 * Methods:
 *              setChecked(bool $checked)
 *              getChecked()
 *              massDelete()
 * (abstract)   saveObj(Table $table)
 * (abstract)   getObj(Table $table, int $sku)
 * (abstract)   printItem()
 */
abstract class Item
{
    protected $sku;
    protected $name;
    protected $price;
    protected $checked = false;

    /**
     * Setter for checked
     */
    public function setChecked(bool $checked)
    {
        $this->checked = $checked;
    }

    /**
     * Getter for checked
     */
    public function getChecked()
    {
        return $this->checked;
    }

    /**
     * A function used for deleting
     * the checked items
     */
    public function massDelete()
    {
    }

    /**
     * An abstract function for storing the properties
     * of the object in the database
     */
    public abstract function saveObj(Table $table);

    /**
     * An abstract function for getting the properties
     * of a single object from the database
     * according to sku
     */
    public abstract function getObj(Table $table, int $sku);

    /**
     * An abstract function for printing
     * the object in the form
     */
    public abstract function printItem();
}
