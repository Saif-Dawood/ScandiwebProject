<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/index/index.css">
    <title>Product List</title>
</head>

<body>
    <header>
        <h1>Product List</h1>
        <input type="button" 
            onclick="window.location.href='addproduct.php';" value="ADD">
        <input type="submit" name="massDelete" 
            id="delete-product-btn" value="MASS DELETE" form="item_form">
    </header>
    <form action="index.php" method="post" id="item_form">

        <?php require("products.php") ?>

        <?php

        use Vendor\Item;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (array_key_exists("massDelete", $_POST)) {
                foreach ($objs as $obj) {
                    $obj->setChecked(array_key_exists($obj->getSku(), $_POST));
                }
                Item::massDelete($table, $objs);
            }
        }
        ?>

    </form>
    <footer>Scandiweb Test Assignment</footer>
</body>

</html>