<html>
    <head>
        <title>Sklep internetowy</title>
        <script src="js/jquery-2.2.4.min.js"></script>
<!--        <script src="js/app.js"></script>-->
        <meta charset="UTF-8">
    </head>
    <body>

        <?php
        if ($_GET['action']) {
            $action = $_GET['action'];
            if (file_exists($action . ".php")) {
                require $action. '.php';
            }
        } else {
            require 'sites/login.php';
        }
        ?>

    </body>
</html>