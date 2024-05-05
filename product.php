<div class="item" <?= $item ?>>
    <div class="checkdiv">
        <input type="checkbox" class="delete-checkbox" name="<?= $sku ?>"><br>
    </div>
    <span><?= $sku ?></span><br>
    <span><?= $name ?></span><br>
    <span><?= $price ?>$</span><br>
    <span><?= $dbdiff ?></span><br>
</div>

<h2 <?= $no_items ?>>No items found in the database</h2>