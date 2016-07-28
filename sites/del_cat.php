<?php
require_once "../config.php";
require_once "../src/dbConnection.php";
if (($_SERVER['REQUEST_METHOD'] == 'GET') and ($_GET['category'])) {
    $conn = connectToDataBase();
    $category = $_GET['category'];
    $query = "DELETE FROM items WHERE category='{$category}'";
    $result = $conn->query($query);
    if ($result = true){
        echo "usunieto kategorie";
        echo "<a href='../index.php?action=sites/admin_panel'>Wroc do panelu administarcyjnego</a>";
    }else{
        echo "nie udalo sie usunac kategorii";
    }
}