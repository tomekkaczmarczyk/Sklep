<html>
    <head>
        <title>Sklep internetowy</title>
        <script src="js/jquery-2.2.4.min.js"></script>
<!--        <script src="js/app.js"></script>-->
        <meta charset="UTF-8">
        <link rel="stylesheet" href="web/css/style.css">
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

    $loggedUser = false;
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $loggedUser = User::getUser($conn, $id);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['mail']) and isset($_POST['password'])) {
            $email = $_POST['mail'];
            $password = $_POST['password'];
            $loggedUser = User::logIn($conn, $email, $password);
            if ($loggedUser) {
                $_SESSION['user_id'] = $loggedUser->getId();
            } else {
                echo "Błędne dane logowania.<br>";
            }
        }
    }

    ?>
    <div class="logdata">
        <?php
        if ($loggedUser) {
            echo "Zalogowano jako: " . $loggedUser->getMail();
        }
        ?>
        <form method="post">
            <button type="submit" name="logout">Wyloguj</button>
        </form>
    </div>
    <div class="menu">
        <ul>
            <li><a href="index.php">Strona główna</a></li>
            <?php
        if($loggedUser) {
            echo "<li><a href='index.php?action=sites/order_site'>Twoje zamówienia</a></li>";
            echo "<li><a href='index.php?action=sites/basket'>Twój koszyk</a></li>";
            echo "<li><a href='index.php?action=sites/user_info'>Informacje o Tobie</a></li>";
        }
        ?>
        </ul>
    </div>
    <div class="categories">
        <p>Kategorie:</p>
        <ul>
        <?php
        $categories = Item::getAllCategories($conn);
        foreach ($categories as $cat) {
            $url = "index.php?action=sites/items_site&category=" . $cat;
            echo "<li><a href='" . $url . "'>" . $cat . "</a></li>";
        }
        ?>
        </ul>
    </div>
    <div class="container">
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
    } elseif ($loggedUser) {
        if ($loggedUser->getIsAdmin()==1) {
            require 'sites/admin_panel.php';
        }
    } else {
        require 'sites/login.php';
    }
    //var_dump($_POST);
    var_dump($_GET);
    //var_dump($_SESSION);
    ?>
    </div>
    </body>
</html>