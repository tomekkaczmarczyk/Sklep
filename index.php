<html>
    <head>
        <title>Sklep internetowy</title>
        <script src="js/jquery-2.2.4.min.js"></script>
<!--        <script src="js/app.js"></script>-->
        <meta charset="UTF-8">
    </head>
    <body>
    <?php
    function __autoload($class_name) {
        include 'src/' . $class_name . '.php';
    }
    require_once 'config.php';
    require_once "src/dbConnection.php";
    $conn = connectToDataBase();
    session_start();
    ?>
    <div>
        <form method="post">
            <button type="submit" name="logout">Wyloguj</button>
        </form>
    </div>
    <div>
        <a href="index.php">Strona główna</a>
    </div>
    <table>
        <?php
        $categories = Item::getAllCategories($conn);
        foreach ($categories as $cat) {
            $url = "index.php?action=sites/items_site&category=" . $cat;
            echo "<tr><td><a href='" . $url . "'>" . $cat . "</a></td></tr>";
        }
        ?>
    </table>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['logout'])) {
        unset($_SESSION['user_id']);
        unset($_GET['action']);
    }

    if (isset($_GET['action'])) {
        $file = $_GET['action'];
        if (file_exists($file . '.php')) {
            require_once $file . '.php';
        }
    } else {
        require 'sites/login.php';
    }
?>
    </body>
</html>

<?php
//var_dump($_POST);
var_dump($_GET);
//var_dump($_SESSION);
?>