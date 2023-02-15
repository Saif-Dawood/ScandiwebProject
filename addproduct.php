<?php
ob_start();

require "Vendor/Database/Database.php";
require "Vendor/Database/Table.php";
require "Vendor/Item.php";
require "Vendor/DVD.php";
require "Vendor/Book.php";
require "Vendor/Furn.php";

use Vendor\Database\Database;
use Vendor\Database\Table;
use Vendor\DVD;
use Vendor\Book;
use Vendor\Furn;

$skuErr = $nameErr = $priceErr = $typeErr = $sizeErr =
    $weightErr = $heightErr = $widthErr = $lengthErr = $diffErr = "";

$sku = $name = $price = $type = $size = $Attr =
    $weight = $height = $width = $length = $diff = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // To check if there is an error
    $oof = 1;

    // Check if any of the fields is empty
    if (empty($_POST['sku'])) {
        $skuErr = "SKU is required";
        $oof = 0;
    } else {
        $sku = test_input($_POST['sku']);
    }
    if (empty($_POST['name'])) {
        $nameErr = "Name is required";
        $oof = 0;
    } else {
        $name = test_input($_POST['name']);
    }
    if (empty($_POST['price'])) {
        $priceErr = "Price is required";
        $oof = 0;
    } else {
        $price = test_input($_POST['price']);
    }
    if (empty($_POST['type'])) {
        $typeErr = "Choose a type";
        $oof = 0;
    } else {
        $type = $_POST['type'];
        if (array_key_exists('size', $_POST)) {
            if (empty($_POST['size'])) {
                $sizeErr = "Size is required";
                $oof = 0;
            } else {
                $size = test_input($_POST['size']);
            }
        } else if (array_key_exists('weight', $_POST)) {
            if (empty($_POST['weight'])) {
                $weightErr = "Weight is required";
                $oof = 0;
            } else {
                $weight = test_input($_POST['weight']);
            }
        } else if (array_key_exists('height', $_POST)) {
            if (empty($_POST['height'])) {
                $heightErr = "Height is required";
                $oof = 0;
            } else {
                $height = test_input($_POST['height']);
            }
            if (empty($_POST['width'])) {
                $widthErr = "Width is required";
                $oof = 0;
            } else {
                $width = test_input($_POST['width']);
            }
            if (empty($_POST['length'])) {
                $lengthErr = "Length is required";
                $oof = 0;
            } else {
                $length = test_input($_POST['length']);
            }
        }
    }
    // Create database if not exists
    $db = new Database("id20302950_scandi");

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

    if (!preg_match("/^[a-zA-Z0-9-]*$/", $sku) && !empty($sku)) {
        $skuErr = "Only letters and numbers are allowed";
        $oof = 0;
    }
    if (!preg_match("/^[a-zA-Z0-9-' ]*$/", $name) && !empty($name)) {
        $nameErr = "Only letters and whitespaces are allowed";
        $oof = 0;
    }
    if ((!filter_var($price, FILTER_VALIDATE_FLOAT) || $price <= 0)
        && !empty($price)
    ) {
        $priceErr = "Only positive decimal numbers are allowed";
        $oof = 0;
    }
    if (array_key_exists('size', $_POST)) {
        // $size = test_input($_POST['size']);
        if ((!filter_var($size, FILTER_VALIDATE_FLOAT) || $size <= 0)
            && !empty($size)
        ) {
            $sizeErr = "Only positive decimal numbers are allowed";
            $oof = 0;
        } else {
            $diff = $size;
        }
    } else if (array_key_exists('weight', $_POST)) {
        // $weight = test_input($_POST['weight']);
        if ((!filter_var($weight, FILTER_VALIDATE_FLOAT) || $weight <= 0)
            && !empty($weight)
        ) {
            $weightErr = "Only positive decimal numbers are allowed";
            $oof = 0;
        } else {
            $diff = $weight;
        }
    } else if (array_key_exists('height', $_POST)) {
        // echo "oof";
        if ((!filter_var($height, FILTER_VALIDATE_FLOAT) || $height <= 0)
            && !empty($height)
        ) {
            // echo "oof";
            $heightErr = "Only positive decimal numbers are allowed";
            $oof = 0;
        } else if ((!filter_var($width, FILTER_VALIDATE_FLOAT)
            || $width <= 0) && !empty($width)) {
            $widthErr = "Only positive decimal numbers are allowed";
            $oof = 0;
        } else if ((!filter_var($length, FILTER_VALIDATE_FLOAT)
            || $length <= 0) && !empty($length)) {
            $lengthErr = "Only positive decimal numbers are allowed";
            $oof = 0;
        } else {
            $diff = $height . "x" . $width . "x" . $length;
        }
    }
    $ttype = "Vendor\\" . $type;
    if ($oof) {
        $obj = new $ttype(
            $sku,
            $name,
            $price,
            $diff
        );
        if (!$obj->saveObj($table)) {
            $skuErr = "This SKU was already used before";
            $oof = 0;
        } else {
            // $Err = "";
            header("refresh: 0; url = index.php");
            ob_end_flush();
        }
    }
    if (!$oof && !empty($type)) {

        $arr['size'] = $size;
        $arr['sizeErr'] = $sizeErr;
        $arr['weight'] = $weight;
        $arr['weightErr'] = $weightErr;
        $arr['height'] = $height;
        $arr['heightErr'] = $heightErr;
        $arr['width'] = $width;
        $arr['widthErr'] = $widthErr;
        $arr['length'] = $length;
        $arr['lengthErr'] = $lengthErr;

        $Attr = $ttype::printHtml($arr);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/addpro/addproduct.css">
    <script src="static/addpro/addproduct.js"></script>
    <title>Product List</title>
</head>

<body>
    <header>
        <h1>Product List</h1>
        <button type="submit" form="product_form" name="save" id="save" class="btn btn-outline-primary">Save</button>
        <input type="button" onclick="window.location.href='index.php';" value="Cancel" class="btn btn-outline-secondary">
    </header>
    <form action="addproduct.php" method="post" id="product_form">

        <!-- <div class="main"> -->
        <span class="text-danger">* Required fields</span>
        <div class="attrib">
            <label for="sku">SKU: </label>
            <input type="text" name="sku" id="sku" value="<?= $sku ?>">
            <span for="sku" class="text-danger">
                * <?= $skuErr ?>
            </span>
        </div>

        <div class="attrib">
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" value="<?= $name ?>">
            <span for="name" class="text-danger">
                * <?= $nameErr ?>
            </span>
        </div>

        <div class="attrib">
            <label for="price">Price ($): </label>
            <input type="text" name="price" id="price" value="<?= $price ?>">
            <span for="price" class="text-danger">
                * <?= $priceErr ?>
            </span>
        </div>

        <div class="attrib">
            <label for="type">Type Switcher: </label>
            <select name="type" id="productType" onchange="displayAttr(this.value)">
                <option value="" disabled <?php if ($type == "") echo "selected"; ?>>
                    Type Switcher
                </option>
                <option value="DVD" <?php if ($type == "DVD") echo "selected"; ?>>DVD-disc</option>
                <option value="Book" <?php if ($type == "Book") echo "selected"; ?>>Book</option>
                <option value="Furn" <?php if ($type == "Furn") echo "selected"; ?>>Furniture</option>
            </select>
            <span for="type" class="text-danger">
                * <?= $typeErr ?>
            </span>
        </div>
        <div id="Attr">
            <?= $Attr ?>
        </div>

    </form>
    <footer>Scandiweb Test Assignment</footer>
</body>

</html>