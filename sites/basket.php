<html>
<head>
    <title>Koszyk</title>
    <meta charset="UTF-8">
</head>
<body>
<div>
    <form method="post">
        <button type="submit" name="logout">Wyloguj</button>
    </form>
</div>

<?php
require_once '../config.php';
require_once '../src/dbConnection.php';
require_once '../src/Order.php';
$conn = connectToDataBase();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' and (($_POST['logout']))) {
    unset($_SESSION['user_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' and ($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $orders = Order::getAllByUser($conn, $user_id);
    foreach ($orders as $order) {
        if ($order->getstatus() == 1) {
            echo $order->getid() . "<br>";
            echo "Data " . $order->getdate() . "<br>";
            echo "Status " . $order->getstatus() . "<br>";
            echo "Suma " . $order->getsum() . "<br>";
            echo "Produkty:<br>";
            $query = "SELECT * FROM item_order WHERE order_id='{$order->getid()}'";
            $result = $conn->query($query);
            $products = [];
            foreach ($result as $row) {
                $products[] = [$row['item_id'], $row['amount']];
            }

            foreach ($products as $product) {
                echo $product[0] . " ilość: ";
                echo $product[1] . "<br>";
            }
        }
    }
} else {
    redirect('../index.php');
}
?>

</body>
</html>