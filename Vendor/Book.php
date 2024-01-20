<?php

namespace Vendor;

use Vendor\Database\TableRow;
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
 *   - getExtraValues(string $var_name): string
 */
class Book extends Item
{
    protected $weight;
    public const PRINT_ADD = array(
        array('lower' => 'weight', 'title' => 'Weight', 'mu' => 'KG')
    );
    public const PRINT_DESCRIPTION = "Please provide the weight of the book";

    /**
     * Book Constructor
     *
     * @param TableRow $row
     * 
     * @override
     */
    public function __construct(TableRow $row)
    {
        parent::__construct($row);
        $this->weight = $row->getColumnValue('weight');
        $this->dbdiff = $row->getColumnValue('dbdiff');
        if ($this->weight == "") {
            $this->weight = $this->dbdiff;
        } else if ($this->dbdiff == "") {
            $this->dbdiff = $this->weight;
        }
        $this->print_dbdiff = "Weight: {$this->weight} KG";
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
        $row = new TableRow();
        $row->setColumnValue('sku', $this->sku);
        $row->setColumnValue('name', $this->name);
        $row->setColumnValue('price', $this->price);
        $row->setColumnValue('type', "Book");
        $row->setColumnValue('dbdiff', $this->dbdiff);
        return $table->addRow($row);
    }

    /**
     * An abstract function for getting the
     * extra values of the child classes
     * 
     * @return string
     */
    public function getExtraValues(string $var_name): string
    {
        if ($var_name == "weight")
            return $this->weight;
        else
            return "";
    }
}