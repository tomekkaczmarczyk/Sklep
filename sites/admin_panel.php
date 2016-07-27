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


?>


<html>
<head>
    <title>Panel administracyjny</title>
    <meta charset="UTF-8">
</head>
<body>
<div>
    <p>Zarządzaj kategoriami:</p>
    <?php
    $conn2 = connectToDataBase();
    $categories = Item::getAllCategories($conn2);

    foreach ($categories as $cat) {
        $url = "items_site.php?category=" . $cat;
        $url2 = "del_cat.php?category=" . $cat;
        echo "<a href='" . $url . "'>" . $cat . "</a>" . "  " . "<a href='" . $url2 . "'>" . "Usun te kategorie" . "</a>" . "<br>";
    };
    ?>

</div>
<p>Dodaj produkt do bazy:</p><br>
<form method="post" action="">
    <label>
        Nazwa:
        <input type="text" name="name"><br>
    </label>
    <label>
        Opis:
        <input type="text" name="description"><br>
    </label>
    <label>
        Kategoria:
        <input type="text" name="category"><br>
    </label>
    <label>
        Cena:
        <input type="text" name="price"><br>
    </label>
    <label>
        Ilosć na stanie:
        <input type="text" name="stock"><br>
    </label>
    <button type="submit">Wyslij dane</button>
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) and isset($_POST['description']) and isset($_POST['category']) and isset($_POST['price']) and isset($_POST['stock'])) {

        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $category = $conn->real_escape_string($_POST['category']);
        $price = $conn->real_escape_string($_POST['price']);
        $stock = $conn->real_escape_string($_POST['stock']);
        $id = -1;

        $item = new Item($name, $description, $category, $price, $stock, $id);


        $item->saveToDb($conn);
        var_dump($item);
        //redirect('admin_panel.php');

    }
}

?>
</div>
<div>
    <p>Produkty:</p>
    <?php
    $query = "SELECT * FROM items";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {

        echo "<table cellpadding=\"2\" border=1>";
        echo "<th>Nazwa</th><th>Opis</th><th>Kategoria</th><th>Cena</th><th>Stan</th><th>Opcje</th>";
        while ($r = $result->fetch_assoc()) {

            echo "<tr>";
            echo "<td>" . $r['name'] . "</td>";
            echo "<td>" . $r['description'] . "</td>";
            echo "<td>" . $r['category'] . "</td>";
            echo "<td>" . $r['price'] . "</td>";
            echo "<td>" . $r['stock'] . "</td>";

            $delurl = "del_item.php?name=" . $r['name'];

            echo "<td> <a href='" . $delurl . "'>Usun</a> </td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>


</div>


</body>
</html>