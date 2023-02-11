<?php
namespace Vendor;

require "../database/crtables.php";

use Exception;
use Vendor\Item;

use function Database\connectDB;

/**
 * A class for DVD-discs
 * 
 * This is a child class to the abstract class Item
 * which contains a new property (size)
 * 
 * Properties:
 *              size: size of the DVD (MB)
 * 
 * Methods:
 *              __construct(string $sku,
 *                          string $name,
 *                          float $price,
 *                          float $size)
 *              saveVars()
 *              getVars()
 *              getVar(int $sku)
 */
class DVD extends Item
{
    protected $size;

    public function __construct (
        string $sku,
        string $name,
        float $price,
        bool $checked,
        float $size
    )
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->checked = $checked;
        $this->size = $size;
    }

    /**
     * A function for storing the properties
     * of the DVD in the database
     */
    public function saveVars()
    {
        // Try connecting
        if (connectDB($conn) === false) {
            return false;
        }

        // Preparing the parameters and binding them
        $stmt = $conn->prepare (
            "INSERT INTO items (
                sku, name, price, checked, type, size, weight, dimensions
            ) VALUES (
                ?, ?, ?, ?, ?, ?, NULL, NULL
            )"
        );
        $stmt->bind_param ("ssdsd",
            $this->sku,
            $this->name,
            $this->price,
            $this->checked,
            "DVD",
            $this->size
        );

        // Execute
        try {
            $stmt->execute();
        } catch (Exception $e) {
            $conn->close();
            return false;
        }

        // Save the changes
        $conn->close();

        // No Errors
        return true;
    }

    /**
     * A function for getting the properties
     * of all the DVDs from the database
     * 
     * Returns -> a num of rows that you can get the values from
     */
    public static function getVars()
    {
        // Try connecting
        if (connectDB($conn) === false) {
            return false;
        }

        // Query for getting the properties
        $sql = "SELECT * FROM items WHERE type = 'DVD'";
        $result = $conn->query($sql);

        // close connection
        $conn->close();

        return $result;
    }

    /**
     * A function for getting the properties
     * of a single DVD according to sku
     * 
     * Returns the corresponding object if found
     */
    public static function getVar(int $sku)
    {
        // Get all objects from the database
        $result = DVD::getVars();
        // Check if at least one object exists
        if ($result === false || $result->num_rows === 0) {
            return false;
        }

        // Search for that $sku
        while ($row = $result->fetch_assoc()) {
            if ($row['sku'] === $sku) {
                break;
            }
        }

        // Found none
        if (!$row) {
            return false;
        }

        // Found!
        // Store properties into a new object
        $obj = new DVD (
            $row['sku'],
            $row['name'],
            $row['price'],
            $row['checked'],
            $row['size']
        );

        // Return the new object
        return $obj;
    }

    /**
     * A function to print the div containing the item
     * in index.php
     */
    public function printItem()
    {
        echo "
            <div class=\"item\">\n
                <input type=\"checkbox\" " . ($this->checked?"checked":"") . "><br>\n
                <label>" . $this->sku . "</label><br>\n
                <label>" . $this->name . "</label><br>\n
                <label>" . $this->price . "$</label><br>\n
                <label>Size: " . $this->size . " MB</label><br>\n
            </div>
        ";
    }
}