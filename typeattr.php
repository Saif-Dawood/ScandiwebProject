<?php
ini_set('display_errors', 1);

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
{
    $obj = new $type("", "", "", array());
    $html = "";
    foreach ($obj->print_add as $field)
    {
        $html .= <<<HTML
            <div class="attrib">
                <label for="{$field['lower']}">{$field['title']}{$field['mu']}: </label>
                <input type="text" name="{$field['lower']}" id="{$field['lower']}" value="">
                <span for="{$field['lower']}" class="text-danger">
                    *
                </span>
            </div>
        HTML;
    }
    $html .= <<<HTML
        <p style="font-weight:bold;">{$obj->print_description}</p>
    HTML;
    echo $html;
}
else
    echo <<<HTML
    <p style="font-weight:bold;">Quit playing with the html of this file</p>
    HTML;