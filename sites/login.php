<form action="index.php" method="post">
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
    <p><a href="index.php?action=sites/register">Nie masz konta? Zarejestruj się!</a></p>
</form>

<?php
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

if($loggedUser) {
    if ($loggedUser->getIsAdmin()==1) {
        redirect('index.php?action=sites/admin_panel');
    } else {
        echo "Zalogowano jako: " . $loggedUser->getMail();
        echo "<p><a href='index.php?action=sites/order_site'>Twoje zamówienia</a></p>";
        echo "<p><a href='index.php?action=sites/basket'>Twój koszyk</a></p>";
        echo "<p><a href='index.php?action=sites/user_info'>Informacje o Tobie</a></p>";

    }
}
?>