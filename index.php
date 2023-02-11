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
    <form action="index.php" method="post">
        <header>
            <h1>Product List</h1>
            <input type="button" 
                onclick="window.location.href='addproduct.php';"
                value="ADD">
            <input type="submit" name="massDelete"
                id="delete-product-btn" value="MASS DELETE">
        </header>
        
        <?php require("products.php")?>

        <footer>Scandiweb Test Assignment</footer>
    </form>
</body>

</html>