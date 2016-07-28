<?php


if (isset($_SESSION['user_id'])) {
    $loggedUser = User::getUser($conn, $_SESSION['user_id']);
    echo "Zalogowano jako: " . $loggedUser->getMail();
}
?>
<div>
    <p>Zarządzaj kategoriami:</p>
    <?php
    $categories = Item::getAllCategories($conn);
    foreach ($categories as $cat) {
        $url = "sites/del_cat.php?category=" . $cat;
        echo "<p>" . $cat . "  <a href='" . $url . "'>" . "Usun te kategorie" . "</a>" . "</p>";
    };
    ?>

</div>
<p>Dodaj produkt do bazy:</p><br>
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
    } else{
        echo "nie udało sie";
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
            echo "<td><FORM ACTION=\"sites/add_photo.php\" METHOD=\"POST\" ENCTYPE=\"multipart/form-data\">
                 <INPUT type=\"file\" name=\"zdjecie\" >
                 <INPUT type='hidden' name='id' value='$id'>
                 <input type=\"submit\" name=\"ok\" value=\"Wyslij zdjęcie do bazy\"/></FORM></td>";

            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</div>