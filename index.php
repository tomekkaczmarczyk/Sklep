<html>
    <head>
        <title>Sklep internetowy</title>
        <script src="js/jquery-2.2.4.min.js"></script>
<!--        <script src="js/app.js"></script>-->
        <meta charset="UTF-8">
    </head>
    <body>
    <div>
        <form method="post">
            <button type="submit" name="logout">Wyloguj</button>
        </form>
    </div>
    <?php
    require_once 'config.php';
    require_once "src/dbConnection.php";
    require_once "src/Item.php";
    require_once 'sites/login.php';
    ?>
    <p><a href="sites/register.php">Nie masz konta? Zarejestruj się!</a></p>
<table>
    <?php

    $conn = connectToDataBase();
    $categories = Item::getAllCategories($conn);
    foreach ($categories as $cat) {
        $url = "sites/items_site.php?category=" . $cat;
        echo "<tr><td><a href='" . $url . "'>" . $cat . "</a></td></tr>";
    }
    ?>
    <p><a href="sites/order_site.php">Twoje zamówienia</a></p>
</table>
    </body>
</html>

<?php
//if ($_GET['action']) {
//    $file = $_GET['action'];
//    if (file_exists($file . '.php')) {
//        require_once $file . '.php';
//    }
//} else {
//    require 'sites/login.php';
//}
//?>