<?php
header('Content-type: image/jpg');
$path = base64_decode($_GET['path']);
$fileContent = file_get_contents($path);
echo $fileContent;