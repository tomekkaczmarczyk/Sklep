<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' and ($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $orders = Order::getAllByUser($conn, $user_id);
    foreach ($orders as $order) {
        if ($order->getstatus() != 1) {
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
//    redirect('index.php');
}
?>
