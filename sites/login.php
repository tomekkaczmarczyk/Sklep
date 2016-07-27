<?php

require_once '../src/dbConnection.php';
require_once '../src/User.php';
require_once '../config.php';

$conn = connectToDataBase();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail']) and isset($_POST['password'])) {
        $email = $_POST['mail'];
        $password = $_POST['password'];
        $loggedUser = User::logIn($conn, $email, $password);
        if ($loggedUser) {
            session_start();
            $_SESSION['user_id'] = $loggedUser->getId();
            redirect('../index.php');
        } else {
            echo "Błędne dane logowania.<br>";
        }
    } else {
        echo "Błędne dane logowania.<br>";
    }
}

?>


<html>
<head>
    <title>Strona logowania</title>
    <meta charset="UTF-8">
</head>
<body>

<form action="../index.php" method="post">
    <table bgcolor="silver">
        <tr>
            <td align="right">
                <label>Mail:
                    <input type="text" name="mail">
                </label>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label>Hasło:
                    <input type="password" name="password">
                </label>
            </td>
        </tr>
        <tr>
            <br>
            <td colspan="2" align="center"><br/>
                <button type="submit" id="btn">Zaloguj</button>
            </td>
        </tr>
    </table>
</form>

</body>
</html>