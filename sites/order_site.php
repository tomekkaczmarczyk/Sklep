<form method="post">
<label>Id:
    <input type="number" step="1" name="id">
</label>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' and ($_POST['id'] != '')) {
    $user_id = $_POST['id'];
    $orders = Order::getAllByUser($conn, $user_id);
    foreach ($orders as $order) {
        echo $order->getid() . "<br>";
        echo $order->getdate() . " ";
        echo $order->getstatus() . " ";
        echo $order->getsum() . "<br>";
    }
}