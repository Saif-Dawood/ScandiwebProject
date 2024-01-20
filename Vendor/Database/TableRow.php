<?php

namespace Vendor\Database;


/**
 * A class for dealing with table rows
 * 
 *
 * Properties:
 *   - columns: an array:
 *                  key: column name
 *                  value: column value
 * 
 * Methods:
 *   - __construct()
 *   - setColumnValue(string $columnName,
 *                    mixed $value): void
 *   - setColumnsValue(array $columns): void
 *   - getColumnValue(string $columnName): mixed
 */
class TableRow
{
    private $columns;

    /**
     * TableRow constructor
     */
    public function __construct()
    {
        $this->columns = [];
    }


    /**
     * A setter function for column values
     *
     * @param string $columnName
     * @param mixed $value
     * @return void
     */
    public function setColumnValue(string $columnName, $value): void
    {
        $this->columns[$columnName] = $value;
    }

    /**
     * A setter function for multiple column values
     * 
     * @param array $columns
     * @return void
     */
    public function setColumnsValue(array $columns): void
    {
        $this->columns = array_merge($this->columns, $columns);
    }


    /**
     * A getter function for column values
     *
     * @param string $columnName
     * @return mixed
     */
    public function getColumnValue(string $columnName): mixed
    {
        return $this->columns[$columnName] ?? "";
    }

}