<?php
require_once "../config.php";
require_once "../src/dbConnection.php";
    if(isset($_FILES['fileToUpload']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];

        $filename = $_FILES['fileToUpload']['name'];
        $uploadfile = '/var/www/html/Sklep/img/' . basename($_FILES['fileToUpload']['name']);
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
            $link = 'show_img.php?path=' . base64_encode($uploadfile) . '';
            $query = "INSERT INTO `photos`(`item_id`, `link`) VALUES ('$id', '$uploadfile')";
            $result = $conn->query($query);
            if($result==true){
                echo "Dodano zdjęcie do bazy.<br>";
                echo '<a href="show_img.php?path=' . base64_encode($uploadfile) . '">Zobacz zdjecie</a><br>';
                echo "<a href='../index.php?action=sites/admin_panel'>Wroc do panelu administarcyjnego</a>";

            } else{
                echo "Nie udalo sie dodac zdjecia do bazy";
            }

        }
    }












//    $fhandle = fopen($_FILES['zdjecie']['tmp_name'], "r");
//    $content = base64_encode(fread($fhandle, $_FILES['zdjecie']['size']));
////    $plik1_tmp = $_FILES['zdjecie']['tmp_name'];
////    $plik1_rozmiar = $_FILES['zdjecie']['size'];
////    $content = addslashes(fread(fopen($plik1_tmp, "r"), $plik1_rozmiar));
//    fclose($fhandle);
//    $id = $_POST['id'];
//
//    $query = "INSERT INTO `photos`(`item_id`, `link`) VALUES ('$id', '$content')";
//    $result = $conn->query($query);
//    $idp = $conn->insert_id;

//    if ($result = true){
//        echo "<a href='../index.php?action=sites/admin_panel'>Wroc do panelu administarcyjnego</a><br>";
//        echo "Dodano zdjecie:";
//        $query2 = "SELECT `link`FROM `photos` WHERE id=".$idp;
//        $result2 = $conn->query($query2);
//        $row = mysqli_fetch_assoc($result2);
//
//
//        $obrazek = base64_decode($row['link']);
//        $obraz = imageCreateFromString($obrazek);
//        imagejpeg($obraz);
//
//
//
//    }else{
//        echo "nie udalo sie przedmiotu";
//    }
//    }