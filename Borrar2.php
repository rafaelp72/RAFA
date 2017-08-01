
<?php
include 'conexionPHP.php';

$ID = $_GET['cod'];


$sql = "DELETE FROM tbusuarios WHERE idusuario=$ID";
$conn->exec($sql);
$conn = null;  

header('location: paginar2.php');

?>