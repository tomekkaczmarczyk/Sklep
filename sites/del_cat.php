<?php

require_once '../src/Item.php';
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 'coderslab';
const DB_NAME = 'shop';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

function connectToDataBase()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$conn) {
        die ("Connection failed. Error: " . $conn->connect_error);
    }
    return $conn;
}

function redirectIfNotLoggedIn()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
    }
}

function redirect($location)
{
    header("Location: $location");
}
if (($_SERVER['REQUEST_METHOD'] == 'GET') and ($_GET['category'])) {
    $conn = connectToDataBase();
    $category = $_GET['category'];
    $query = "DELETE FROM items WHERE category='{$category}'";
    $result = $conn->query($query);
    if ($result = true){
        echo "usunieto kategorie";
        echo "<a href='admin_panel.php'>Wroc do panelu administarcyjnego</a>";
    }else{
        echo "nie udalo sie usunac kategorii";
    }
}