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
 *   - __construct(string $sku,
 *   -             string $name,
 *   -             string $price,
 *   -             array $data)
 *   - saveObj(Table $table)
 *   - getExtraValues(string $var_name): string
 */
class Furn extends Item
{
    protected $length;
    protected $width;
    protected $height;
    public const PRINT_ADD = array(
        array('lower' => 'height', 'title' => 'Height', 'mu' => 'CM'),
        array('lower' => 'width', 'title' => 'Width', 'mu' => 'CM'),
        array('lower' => 'length', 'title' => 'Length', 'mu' => 'CM')
    );
    public const PRINT_DESCRIPTION = "Please provide the dimensions of the furniture";

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
        $row->setColumnValue('type', "Furn");
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
        if ($var_name == "height")
            return $this->height;
        else if ($var_name == "width")
            return $this->width;
        else if ($var_name == "length")
            return $this->length;
        else
            return "";
    }
}