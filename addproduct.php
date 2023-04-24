<?php require "validator.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/addpro/addproduct.css">
    <script src="static/addpro/addproduct.js"></script>
    <title>Add Product</title>
</head>

<body>
    <header>
        <h1>Add Product</h1>
        <button type="submit" form="product_form" name="save" id="save" class="btn btn-outline-primary">Save</button>
        <input type="button" onclick="window.location.href='index.php';" value="Cancel"
            class="btn btn-outline-secondary">
    </header>
    <form action="addproduct.php" method="post" id="product_form">

        <span class="text-danger">* Required fields</span>
        <div class="attrib">
            <label for="sku">SKU: </label>
            <input type="text" name="sku" id="sku" value="<?= $data['sku'] ?>">
            <span for="sku" class="text-danger">
                *
                <?= $errors['sku'] ?>
            </span>
        </div>

        <div class="attrib">
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" value="<?= $data['name'] ?>">
            <span for="name" class="text-danger">
                *
                <?= $errors['name'] ?>
            </span>
        </div>

        <div class="attrib">
            <label for="price">Price ($): </label>
            <input type="text" name="price" id="price" value="<?= $data['price'] ?>">
            <span for="price" class="text-danger">
                *
                <?= $errors['price'] ?>
            </span>
        </div>

        <div class="attrib">
            <label for="type">Type Switcher: </label>
            <select name="type" id="productType" onchange="displayAttr(this.value)">
                <option value="" disabled <?php if ($data['type'] == "")
                    echo "selected"; ?>>
                    Type Switcher
                </option>
                <option value="DVD" <?php if ($data['type'] == "DVD")
                    echo "selected"; ?>>
                    DVD-disc
                </option>
                <option value="Book" <?php if ($data['type'] == "Book")
                    echo "selected"; ?>>
                    Book
                </option>
                <option value="Furn" <?php if ($data['type'] == "Furn")
                    echo "selected"; ?>>
                    Furniture
                </option>
            </select>
            <span for="type" class="text-danger">
                *
                <?= $errors['type'] ?>
            </span>
        </div>
        <div id="Attr">
            <?= $Attr ?>
        </div>

    </form>
    <footer>Scandiweb Test Assignment</footer>
</body>

</html>