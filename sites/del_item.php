<?php
require_once "../config.php";
require_once "../src/dbConnection.php";
if (($_SERVER['REQUEST_METHOD'] == 'GET') and ($_GET['name'])) {
    $conn = connectToDataBase();
    $name = $_GET['name'];
    $query = "DELETE FROM items WHERE name='{$name}'";
    $result = $conn->query($query);
    if ($result = true){
        echo "usunieto przedmiot";
        echo "<a href='../index.php?action=sites/admin_panel'>Wroc do panelu administarcyjnego</a>";
    }else{
        echo "nie udalo sie przedmiotu";
    }
}