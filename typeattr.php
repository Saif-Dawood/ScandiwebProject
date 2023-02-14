<?php

require "Vendor\\Item.php";
require "Vendor\\DVD.php";
require "Vendor\\Book.php";
require "Vendor\\Furn.php";

use Vendor\Item;
use Vendor\DVD;
use Vendor\Book;
use Vendor\Furn;

$type = $_REQUEST["t"];

$type = "Vendor\\" . $type;
$type::printHtml();