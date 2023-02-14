<?php
require "Vendor\\Database\\Database.php";
require "Vendor\\Database\\Table.php";
require "Vendor\\Item.php";
require "Vendor\\DVD.php";
require "Vendor\\Book.php";
require "Vendor\\Furn.php";

use Vendor\Database\Database;
use Vendor\Database\Table;
use Vendor\DVD;
use Vendor\Book;
use Vendor\Furn;

$Err = "* Required field";

$sku = $name = $price = $type = $size =
    $weight = $height = $width = $length = $diff = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST['sku']) ||
        empty($_POST['name']) ||
        empty($_POST['price']) ||
        empty($_POST['type']) ||
        (array_key_exists('size', $_POST) && empty($_POST['size'])) ||
        (array_key_exists('weight', $_POST) && empty($_POST['weight'])) ||
        (array_key_exists('height', $_POST) && empty($_POST['height'])) ||
        (array_key_exists('width', $_POST) && empty($_POST['width']))
    ) {
        (array_key_exists('length', $_POST) && empty($_POST['length'])) ||
            $Err = "Missing required fields";
    } else {
        // Create database if not exists
        $db = new Database("scandi");

        // Define Columns
        $cols['id'] = array(
            "INT(6)", "UNSIGNED", "AUTO_INCREMENT",
            "PRIMARY KEY"
        );
        $cols['sku'] = array("VARCHAR(12)", "UNIQUE", "NOT NULL");
        $cols['name'] = array("VARCHAR(30)", "NOT NULL");
        $cols['price'] = array("REAL(6,2)", "UNSIGNED", "NOT NULL");
        $cols['type'] = array("VARCHAR(4)", "NOT NULL");
        $cols['dbdiff'] = array("VARCHAR(30)", "NOT NULL");

        // Create table if not exists
        $table = new Table($db, "items", $cols);

        // To check if there is an error
        $oof = 1;

        $sku = test_input($_POST['sku']);
        $name = test_input($_POST['name']);
        $price = test_input($_POST['price']);
        $type = "Vendor\\" . $_POST['type'];
        if (!preg_match("/^[a-zA-Z0-9-]*$/", $sku)) {
            $Err = "SKU: Only letters and numbers are allowed";
            $oof = 0;
        } else if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $Err = "Name: Only letters and whitespaces are allowed";
            $oof = 0;
        } else if (!filter_var($price, FILTER_VALIDATE_FLOAT)) {
            $Err = "Price: Only Decimal numbers are allowed";
            $oof = 0;
        } else if (array_key_exists('size', $_POST)) {
            $size = test_input($_POST['size']);
            if (!filter_var($size, FILTER_VALIDATE_FLOAT)) {
                $Err = "Size: Only Decimal numbers are allowed";
                $oof = 0;
            } else {
                $diff = $size;
            }
        } else if (array_key_exists('weight', $_POST)) {
            $weight = test_input($_POST['weight']);
            if (!filter_var($weight, FILTER_VALIDATE_FLOAT)) {
                $Err = "Weight: Only Decimal numbers are allowed";
                $oof = 0;
            } else {
                $diff = $weight;
            }
        } else if (array_key_exists('height', $_POST)) {
            $height = test_input($_POST['height']);
            $width = test_input($_POST['width']);
            $length = test_input($_POST['length']);
            if (!filter_var($height, FILTER_VALIDATE_FLOAT)) {
                $Err = "Height: Only Decimal numbers are allowed";
                $oof = 0;
            } else if (!filter_var($width, FILTER_VALIDATE_FLOAT)) {
                $Err = "Width: Only Decimal numbers are allowed";
                $oof = 0;
            } else if (!filter_var($length, FILTER_VALIDATE_FLOAT)) {
                $Err = "Length: Only Decimal numbers are allowed";
                $oof = 0;
            } else {
                $diff = $height . "x" . $width . "x" . $length;
            }
        }
        if ($oof) {
            $obj = new $type(
                $sku,
                $name,
                $price,
                $diff
            );
            if (!$obj->saveObj($table)) {
                $Err = "SKU: This SKU was already used before";
            } else {
                $Err = "";
                header("refresh: 0; url = index.php");
            }
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="static/addproduct/addproduct.css">
    <script src="static/addproduct/addproduct.js"></script>
    <title>Product List</title>
</head>

<body>
    <header>
        <h1>Product List</h1>
        <button type="submit" form="product_form" name="save" id="save">Save</button>
        <input type="button" onclick="window.location.href='index.php';" value="Cancel">
    </header>
    <form action="addproduct.php" method="post" id="product_form">

        <div class="main">
            <span class="text-danger"><?= $Err; ?></span>
            <div>
                <label for="sku">SKU: </label>
                <input type="text" name="sku" id="sku">
                <span for="sku" class="text-danger">
                    *
                </span>
            </div>

            <div>
                <label for="name">Name: </label>
                <input type="text" name="name" id="name">
                <span for="name" class="text-danger">
                    *
                </span>
            </div>

            <div>
                <label for="price">Price ($): </label>
                <input type="text" name="price" id="price">
                <span for="price" class="text-danger">
                    *
                </span>
            </div>

            <div>
                <label for="type">Type Switcher: </label>
                <select name="type" id="type" onchange="displayAttr(this.value)">
                    <option value="" disabled selected>
                        Type Switcher
                    </option>
                    <option value="DVD">DVD-disc</option>
                    <option value="Book">Book</option>
                    <option value="Furn">Furniture</option>
                </select>
                <span for="type" class="text-danger">
                    *
                </span>
            </div>
            <div id="Attr">

            </div>
        </div>

    </form>
    <footer>Scandiweb Test Assignment</footer>
</body>

</html>