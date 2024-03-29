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

if (class_exists($type)) {
    $html = "";
    foreach ($type::PRINT_ADD as $field) {
        $html .= <<<HTML
            <div class="attrib">
                <label for="{$field['lower']}">{$field['title']} ({$field['mu']}): </label>
                <input type="text" name="{$field['lower']}" id="{$field['lower']}"
                    class="req_field dec_field" value="">
                <span for="{$field['lower']}" class="text-danger" id="err_{$field['lower']}">
                    *
                </span>
            </div>
        HTML;
    }
    $html .= <<<HTML
        <p style="font-weight:bold;">
    HTML . $type::PRINT_DESCRIPTION . "</p>";

    echo $html;
} else {
    echo <<<HTML
    <p style="font-weight:bold;">Quit playing with the html of this file</p>
    HTML;
}