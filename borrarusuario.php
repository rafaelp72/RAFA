<?php
ob_start();
include 'conexionPHP.php';

$IDU = $_GET['cod'];


$sql = "DELETE FROM tbusuarios WHERE idusuario=$IDU";
$conn->exec($sql);
$sql = "DELETE FROM tbcomentarios WHERE idusuario=$IDU";
$conn->exec($sql);
$conn = null;  

header('location: paginar.php');
ob_end_flush();
?>