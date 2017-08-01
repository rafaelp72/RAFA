<?php
ob_start();
include 'conexionPHP.php';

$ID = $_GET['cod'];


$sql = "DELETE FROM tbcomentarios WHERE idcomentario=$ID";
$conn->exec($sql);
$conn = null;  

header('location: paginar.php');
ob_end_flush();
?>
