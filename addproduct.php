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
    <form action="addproduct.php" method="post" id="product_form" onsubmit="return validateForm()">

        <span class="text-danger">* Required fields</span>
        <div class="attrib">
            <label for="sku">SKU: </label>
            <input type="text" name="sku" id="sku" class="req_field let_field sku_field" value="<?= $data['sku'] ?>">
            <span for="sku" class="text-danger" id="err_sku">
                *
                <?= $sku_err ?>
            </span>
        </div>

        <div class="attrib">
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" class="req_field space_field" value="<?= $data['name'] ?>">
            <span for="name" class="text-danger" id="err_name">
                *
            </span>
        </div>

        <div class="attrib">
            <label for="price">Price ($): </label>
            <input type="text" name="price" id="price" class="req_field dec_field" value="<?= $data['price'] ?>">
            <span for="price" class="text-danger" id="err_price">
                *
            </span>
        </div>

        <div class="attrib">
            <label for="type">Type Switcher: </label>
            <select name="type" id="productType" class="req_field type_field" onchange="displayAttr(this.value)">
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
            <span for="type" class="text-danger" id="err_type">
                *
            </span>
        </div>
        <div id="Attr">

        </div>
        <div id="DVD" class="dont_affect" hidden>
            <div class="attrib">
                <label for="size">Size (MB): </label>
                <input type="text" name="" id="size" class="req_field dec_field" value="">
                <span for="size" class="text-danger" id="err_size">
                    *
                </span>
            </div>
            <p style="font-weight:bold;">
                Please provide the size of the disc
            </p>
        </div>
        <div id="Book" class="dont_affect" hidden>
            <div class="attrib">
                <label for="weight">Weight (KG): </label>
                <input type="text" name="" id="weight" class="req_field dec_field" value="">
                <span for="weight" class="text-danger" id="err_weight">
                    *
                </span>
            </div>
            <p style="font-weight:bold;">
                Please provide the weight of the book
            </p>
        </div>
        <div id="Furn" class="dont_affect" hidden>
            <div class="attrib">
                <label for="height">Height (CM): </label>
                <input type="text" name="" id="height" class="req_field dec_field" value="">
                <span for="height" class="text-danger" id="err_height">
                    *
                </span>
            </div>
            <div class="attrib">
                <label for="width">Width (CM): </label>
                <input type="text" name="" id="width" class="req_field dec_field" value="">
                <span for="width" class="text-danger" id="err_width">
                    *
                </span>
            </div>
            <div class="attrib">
                <label for="length">Length (CM): </label>
                <input type="text" name="" id="length" class="req_field dec_field" value="">
                <span for="length" class="text-danger" id="err_length">
                    *
                </span>
            </div>
            <p style="font-weight:bold;">
                Please provide the dimensions of the furniture
            </p>
        </div>
        <div id="type_err" class="dont_affect" hidden>
            <p style="font-weight:bold;">Quit playing with the html of this file</p>
        </div>

    </form>
    <footer>Scandiweb Test Assignment</footer>
</body>

</html>