<?php

require "Vendor/Item.php";
require "Vendor/DVD.php";
require "Vendor/Book.php";
require "Vendor/Furn.php";

use Vendor\Item;
use Vendor\DVD;
use Vendor\Book;
use Vendor\Furn;

$type = $_REQUEST["t"];

$type = "Vendor\\" . $type;

$arr['size'] = "";
$arr['sizeErr'] = "";
$arr['weight'] = "";
$arr['weightErr'] = "";
$arr['height'] = "";
$arr['heightErr'] = "";
$arr['width'] = "";
$arr['widthErr'] = "";
$arr['length'] = "";
$arr['lengthErr'] = "";

echo $type::printHtml($arr);