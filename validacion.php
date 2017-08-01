<?php
ob_start();
session_start(); // $_SESSION["perfil"] de validacion.php a comentarios.php  y a paginar.php
include 'conexionPHP.php';


if (isset($_GET['cod'])){$email = $_GET['cod'];}
if (isset($_GET['cod2'])){$pass = $_GET['cod2'];}

$query = $conn->prepare("SELECT * FROM tbusuarios where Email='$email' and Password='$pass'");	
$query->execute();		
$result = $query->fetch();
$var1 = $result['Idusuario'];
//$var2 = $result['Nombre'] ;
$_SESSION["perfil"] = $result['Nombre'];
$conn = null;	

$cont
if (($result) && $cont < 3)
{
//header('location:comentarios.php?codID='.$var1.'&codNOM='.$var2); 
header('location:comentarios.php?codID='.$var1); 
}			
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  
  </br></br>
  <div class="alert alert-danger text-center">
    <strong>ERROR!!!</strong>no coinciden los datos. 
  </div>
       
    
  <div>
 	<button type="button" class="btn btn-warning btn-block" id="reg">VOLVER a INDEX</button>
  </div>
</div>

 <script>
 document.getElementById("reg").onclick = function(){volver()}
 function volver(){location.href="index.php"}	
 </script>

</body>
</html>
<?php
ob_end_flush();
?>