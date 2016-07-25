<?php
require_once '../src/dbConnection.php';
require_once '../src/User.php';

$conn = connectToDataBase();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail']) and isset($_POST['password']) and isset($_POST['name']) and isset($_POST['surname']) and isset($_POST['address'])) {
        $id = -1;
        $mail = $conn->real_escape_string($_POST['mail']);
        $hashedpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $name = $conn->real_escape_string($_POST['name']);
        $surname = $conn->real_escape_string($_POST['surname']);
        $address = $conn->real_escape_string($_POST['address']);
        $is_admin = 0;
        $user = new User($id, $name, $surname, $mail, $hashedpassword, $address);
        var_dump($user);
        $user->saveUser($conn);
        redirect('login.php');
        var_dump($user);
    }
}

?>

<html>
<head>
    <title>Formularz rejestracji</title>
    <meta charset="UTF-8">
</head>
<body>
<form action="" method="post">
    <table bgcolor="silver">
        <tr>
            <td align="right">
                <label>Imię:
                    <input type="text" name="name" placeholder="Jan">
                </label>
            </td>
        </tr>

        <tr>
            <td align="right">
                <label>Nazwisko:
                    <input type="text" name="surname" placeholder="Kowalski">
                </label>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label>Email:
                    <input type="email" name="mail" placeholder="jan.kowalski@gmail.com">
                </label>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label>Hasło:
                    <input type="password" name="password" placeholder="********">
                </label>
            </td>
        </tr>
        <tr>
            <td align="right">
                <label>Adres:
                    <input type="text" name="address" placeholder="ul. Woronicza 17, 00-000 Warszawa">
                </label>
            </td>
        </tr>
        <tr>
            <br>
            <td colspan="2" align="center"><br/>
                <input type="submit" value="Wyślij"/>
                <input type="reset" value="Wyczyść"/>
            </td>
        </tr>
    </table>
</form>
</body>
</html>

