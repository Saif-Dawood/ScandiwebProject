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
 *   - __construct(TableRow $row)
 *   - saveObj(Table $table)
 */
class Book extends Item
{
    protected $weight;

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
     * @return bool
     * 
     * @override
     */
    public function saveObj(Table $table): bool
    {
        $row = new TableRow();
        $row->setColumnValue('sku', $this->sku);
        $row->setColumnValue('name', $this->name);
        $row->setColumnValue('price', $this->price);
        $row->setColumnValue('type', "Book");
        $row->setColumnValue('dbdiff', $this->dbdiff);
        return $table->addRow($row);
    }
}