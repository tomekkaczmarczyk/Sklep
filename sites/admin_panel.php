<?php


if (isset($_SESSION['user_id'])) {
    $loggedUser = User::getUser($conn, $_SESSION['user_id']);
    echo "<h2>"."Zalogowano jako Admin: " . $loggedUser->getMail()."</h2>";
}
?>
<div>
    <h3>Zarządzaj kategoriami:</h3>
    <?php
    $categories = Item::getAllCategories($conn);
    foreach ($categories as $cat) {
        $url = "sites/del_cat.php?category=" . $cat;
        echo "<p>" . $cat . "  <a href='" . $url . "'>" . "Usun te kategorie" . "</a>" . "</p>";
    };
    ?>
    </div>
<div>
<h3>Dodaj produkt do bazy:</h3>
<form method="post" action="index.php?action=sites/admin_panel">
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
        <input type="number" name="price" step="0.01" min="0"><br>
    </label>
    <label>
        Ilosć na stanie:
        <input type="number" name="stock" step="1" min="0"><br>
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
        echo "Produkt zapisano";
    } else {
        echo "nie udało sie";
    }
}

?>
</div>
<div>
    <h3>Produkty:</h3>
    <?php
    $query = "SELECT * FROM items";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {

        echo "<table cellpadding=\"2\" border=1>";
        echo "<th>Nazwa</th><th>Opis</th><th>Kategoria</th><th>Cena</th><th>Stan</th><th>Opcje</th><th>Dodaj zdjęcie</th>";
        while ($r = $result->fetch_assoc()) {

            echo "<tr>";
            echo "<td>" . $r['name'] . "</td>";
            echo "<td>" . $r['description'] . "</td>";
            echo "<td>" . $r['category'] . "</td>";
            echo "<td>" . $r['price'] . "</td>";
            echo "<td>" . $r['stock'] . "</td>";

            $id = $r['id'];
            $delurl = "sites/del_item.php?name=" . $r['name'];

            echo "<td> <a href='" . $delurl . "'>Usun</a> </td>";
            echo "<td><form action=\"sites/add_photo.php\" method=\"post\" enctype=\"multipart/form-data\">
            <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
            <input type='hidden' name='id' value='$id'>
            <input type=\"submit\" value=\"Wyslij zdjecie\" name=\"submit\"></form></td>";

            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</div>
<div>
    <h3>Zarządzaj użytkownikami</h3>

    <?php
    $query = "SELECT * FROM users";
    $result = $conn->query($query);


    echo "<table cellpadding=\"2\" border=1>";
    echo "<th>Id</th><th>Imie</th><th>Nazwisko</th><th>Mail</th><th>Adres</th><th>Administrator</th><th>Opcje</th>";
    while ($u = $result->fetch_assoc()) {

        echo "<tr>";
        echo "<td>" . $u['id'] . "</td>";
        echo "<td>" . $u['name'] . "</td>";
        echo "<td>" . $u['surname'] . "</td>";
        echo "<td>" . $u['mail'] . "</td>";
        echo "<td>" . $u['address'] . "</td>";
        echo "<td>" . $u['is_admin'] . "</td>";

        $delur2 = "sites/del_user.php?id=" . $u['id'];

        echo "<td> <a href='" . $delur2 . "'>Usun</a> </td>";

        echo "</tr>";
    }
    echo "</table>";

    ?>

</div>