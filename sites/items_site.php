<form method="post">
    <label>Wybierz kategorię:
    <select name="category">
        <option value="piwo">Piwo</option>
        <option value="wino">Wino</option>
    </select>
    </label>
    <button type="submit" class="btn">Wybierz</button>
</form>

<?php

if (($_SERVER['REQUEST_METHOD'] == 'POST') and $_POST['category'] != '') {
    require_once 'src/Item.php';
    require_once 'src/dbConnection.php';
    $conn = connectToDataBase();
    $category = $_POST['category'];
    $items = Item::getAllByCategory($conn, $category);
    foreach ($items as $item) {
        echo $item->getName() . "<br>";
    }
}