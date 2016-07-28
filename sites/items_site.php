<table>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET['category'])) {
    $category = $_GET['category'];
    $items = Item::getAllByCategory($conn, $category);
    foreach ($items as $item) {
        $url = "index.php?action=sites/basket&item_add_id=" . $item->getId();
        echo "<tr><td>" . $item->getName() . "</td>";
        echo "<td><a href='" . $url . "'>Dodaj do koszyka</a></td></tr>";
    }
}
?>
</table>