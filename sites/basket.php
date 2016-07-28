<?php
$basket = Order::getBasket($conn, $_SESSION['user_id']);
$basket_id = $basket->getid();
if (isset($_GET['item_add_id'])) {
    $newItemId = $_GET['item_add_id'];
    $query = "INSERT INTO `item_order` (`item_id`, `amount`, `order_id`)"
        . "VALUES ('{$newItemId}', '1', '{$basket_id}')";
    $result = $conn->query($query);
    if (!$result) {
        echo "Błąd dodania produktu to zamówienia" . $conn->error;
    }
}

echo $basket_id . "<br>";
echo "Data " . $basket->getdate() . "<br>";
echo "Status " . $basket->getstatus() . "<br>";
echo "Suma " . $basket->getsum() . "<br>";
echo "Produkty:<br>";
$query = "SELECT * FROM item_order WHERE order_id='{$basket->getid()}'";
$result = $conn->query($query);
$products = [];
foreach ($result as $row) {
    $products[] = [$row['item_id'], $row['amount']];
}
?>
<table border="1px">
    <tr><td>Produkt</td>
    <td>Ilość</td></tr>
<?php
foreach ($products as $product) {
    $id = $product[0];
    $amount = $product[1];
    $item = Item::getById($conn, $id);
    $name = $item->getName();
    echo "<tr>";
    echo "<td>" . $name .  "</td>";
    echo "<td>" . $amount . "</td>";
    echo "</tr>";
}
?>
</table>

