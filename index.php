<?php require "massdelete.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/index/indexx.css">
    <title>Product List</title>
</head>

<body>
    <header>
        <h1>Product List</h1>
        <input type="button" onclick="window.location.href='addproduct.php';" value="ADD"
            class="btn btn-outline-primary">
        <input type="submit" name="massDelete" id="delete-product-btn" value="MASS DELETE" form="item_form"
            class="btn btn-outline-secondary">
    </header>
    <form action="index.php" method="post" id="item_form">

        <?php require "products.php" ?>
        
    </form>
    <footer>Scandiweb Test Assignment</footer>
</body>

</html>