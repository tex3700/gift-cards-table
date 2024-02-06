
<?php foreach ($stories as $story): ?>
    <option value="<?= $story["store_id"] ?>"><?= $story["store_name"] ?></option>
<?php endforeach; ?>
