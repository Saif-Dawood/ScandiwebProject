<?php

namespace Vendor;

use Vendor\Database\Table;
use Vendor\Database\TableRow;
use Vendor\Item;

/**
 * A class for DVD-discs
 *
 * This is a child class to the abstract class Item
 * which contains a new property (size)
 *
 * Properties:
 *   - size: size of the DVD (MB)
 *
 * Methods:
 *   - __construct(string $sku,
 *   -             string $name,
 *   -             string $price,
 *   -             array $data)
 *   - saveObj(Table $table)
 *   - getExtraValues(string $var_name): string
 */
class DVD extends Item
{
    protected $size;
    public const PRINT_ADD = array(
        array('lower' => 'size', 'title' => 'Size', 'mu' => 'MB')
    );
    public const PRINT_DESCRIPTION = "Please provide the size of the disc";

    /**
     * DVD Constructor
     * 
     * @param TableRow $row
     * 
     * @override
     */
    public function __construct(TableRow $row)
    {
        parent::__construct($row);
        $this->size = $row->getColumnValue('size');
        $this->dbdiff = $row->getColumnValue('dbdiff');
        if ($this->size == "") {
            $this->size = $this->dbdiff;
        } else if ($this->dbdiff == "") {
            $this->dbdiff = $this->size;
        }
        $this->print_dbdiff = "Size: {$this->size} MB";
    }

    /**
     * A function for storing the properties
     * of the DVD in the database
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
        $row->setColumnValue('type', "DVD");
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
        if ($var_name == "size")
            return $this->size;
        else
            return "";
    }
}