<?php
require_once "../config.php";
require_once "../src/dbConnection.php";
if (($_SERVER['REQUEST_METHOD'] == 'POST') and ($_FILES['zdjecie'])) {

    $fhandle = fopen($_FILES['zdjecie']['tmp_name'], "r");
    $content = base64_encode(fread($fhandle, $_FILES['zdjecie']['size']));
//    $plik1_tmp = $_FILES['zdjecie']['tmp_name'];
//    $plik1_rozmiar = $_FILES['zdjecie']['size'];
//    $content = addslashes(fread(fopen($plik1_tmp, "r"), $plik1_rozmiar));
  fclose($fhandle);
    $id = $_POST['id'];



    $query = "INSERT INTO `photos`(`item_id`, `link`) VALUES ('$id', '$content')";
    echo"$query";
    $result = $conn->query($query);
    if ($result = true){
        echo "dodano zdjecie";
        echo "<a href='../index.php?action=sites/admin_panel'>Wroc do panelu administarcyjnego</a>";
    }else{
        echo "nie udalo sie przedmiotu";
    }
    }