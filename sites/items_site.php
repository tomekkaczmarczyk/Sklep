<meta charset="UTF-8">
<table>
    <?php
    require_once "../config.php";
    require_once "../src/dbConnection.php";
    require_once "../src/Item.php";
    $conn = connectToDataBase();
    $categories = Item::getAllCategories($conn);
    foreach ($categories as $cat) {
        $url = "items_site.php?category=" . $cat;
        echo "<tr><td><a href='" . $url . "'>" . $cat . "</a></td></tr>";
    }
    ?>
</table>

<?php

if (($_SERVER['REQUEST_METHOD'] == 'GET') and ($_GET['category'])) {
    $conn = connectToDataBase();
    $category = $_GET['category'];
    $items = Item::getAllByCategory($conn, $category);
    foreach ($items as $item) {
        echo $item->getName() . "<br>";
    }
}