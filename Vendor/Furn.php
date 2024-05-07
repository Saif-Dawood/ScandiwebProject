<?php

namespace Vendor;

use Vendor\Database\Table;
use Vendor\Database\TableRow;

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
 *   - __construct(TableRow $row)
 *   - saveObj(Table $table)
 */
class Furn extends Item
{
    protected $length;
    protected $width;
    protected $height;

    /**
     * Furniture Constructor
     * 
     * @param TableRow $row
     * 
     * @override
     */
    public function __construct(TableRow $row)
    {
        parent::__construct($row);
        $this->length = $row->getColumnValue('length');
        $this->width = $row->getColumnValue('width');
        $this->height = $row->getColumnValue('height');
        $this->dbdiff = $row->getColumnValue('dbdiff');
        if ($this->length != "") {
            $this->dbdiff = "$this->length" . 'x' .
                "$this->width" . 'x' .
                "$this->height";
        }
        $this->print_dbdiff = "Dimensions: {$this->dbdiff}";
    }

    /**
     * A function for storing the properties
     * of the Furn in the database
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
        $row->setColumnValue('type', "Furn");
        $row->setColumnValue('dbdiff', $this->dbdiff);
        return $table->addRow($row);
    }
}