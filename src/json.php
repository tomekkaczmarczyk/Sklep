<?php
header('Content-Type: application/json');

require_once "../src/dbConnection.php";
require_once "../src/Item.php";

$conn = connectToDataBase();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $items = Item::getAllByCategory($conn, $category);
    $itemsJS = json_encode($items);
    echo($itemsJS);
}

