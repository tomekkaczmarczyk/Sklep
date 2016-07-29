<?php
require_once "../config.php";
require_once "../src/dbConnection.php";

if (($_SERVER['REQUEST_METHOD'] == 'GET') and ($_GET['id'])) {
    $conn = connectToDataBase();
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id='{$id}'";
    var_dump($query);
    $result = $conn->query($query);
    if ($result = true) {
        echo "usunieto uzytkownika";
        echo "<a href='../index.php?action=sites/admin_panel'>Wroc do panelu administarcyjnego</a>";
    } else {
        echo "nie udalo sie usunac uzytkownika";
    }
}