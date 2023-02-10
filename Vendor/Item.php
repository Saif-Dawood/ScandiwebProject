<?php
namespace Vendor;

/**
 * A class for all the items
 * 
 * This is an abstract parent class for any type of item and types are going to be its childs
 * 
 * Properties:
 *              sku: a unique code for each item
 *              name: item's name
 *              price: item's price
 * 
 * Methods:
 *              __construct(string $sku, string $name, float $price)
 * (abstract)   saveVars()
 * (abstract)   getVars()
 */
abstract class Item
{
    protected $sku;
    protected $name;
    protected $price;

    public function __construct(string $sku, string $name, float $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * An abstract function for storing the properties
     * of the object in the database
     */
    public abstract function saveVars();

    /**
     * An abstract function for getting the properties
     * of the object from the database
     */
    public abstract function getVars();
}