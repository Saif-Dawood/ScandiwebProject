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

if (class_exists($type))
    echo $type::printHtml();
else
    echo <<<HTML
    <p style="font-weight:bold;">Quit playing with the html of this file</p>
    HTML;