<?php
function connectToDataBase() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$conn) {
        die ("Connection failed. Error: " . $conn->connect_error);
    }
    return $conn;
}

function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
    }
}

function redirect($location) {
    header("Location: $location");
}

