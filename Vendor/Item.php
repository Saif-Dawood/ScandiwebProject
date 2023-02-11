<?php
namespace Vendor;

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
 * 
 * Methods:
 * (abstract)   saveVars()
 * (abstract)   getVars()
 */
abstract class Item
{
    protected $sku;
    protected $name;
    protected $price;
    protected $checked = false;

    /**
     * An abstract function for storing the properties
     * of the object in the database
     */
    public abstract function saveVars();

    /**
     * An abstract function for getting the properties
     * of all the objects of the same type from the database
     */
    public abstract static function getVars();

    /**
     * An abstract function for getting the properties
     * of a single object from the database
     * according to sku
     */
    public abstract static function getVar(int $sku);

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
     * An abstract function for printing
     * the object in the form
     */
    public abstract function printItem();

    /**
     * A function used for deleting
     * the checked items
     */
    public function massDelete()
    {

    }
}