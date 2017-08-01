<?php
ob_start();
include 'conexionPHP.php';

$IDU = $_GET['cod'];



$sql = "UPDATE tbusuarios SET Bloqueado='0' WHERE idusuario=$IDU";
$conn->exec($sql);
$conn = null;  

header('location: paginar.php');
ob_end_flush();
?>