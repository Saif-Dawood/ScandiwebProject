<?php
ob_start();


use Vendor\Item;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists("massDelete", $_POST)) {
        foreach ($objs as $obj) {
            $obj->setChecked(array_key_exists($obj->getSku(), $_POST));
        }
        Item::massDelete($table, $objs);
        header("refresh: 0");
        ob_end_flush();
    }
}