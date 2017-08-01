<?php
ob_start();
session_start(); // $_SESSION["perfil"] de alta.php a comentarios.php  y a paginar.php
$ID = $_GET['codID'];
if (isset($_POST['alta']))
	{		
		$comen=$_POST['txtcomentarios'];		
		
		include 'conexionPHP.php';

		try {
			$sql = "INSERT INTO tbcomentarios (idusuario,Comentario)
			VALUES ('$ID','$comen')";			
			$conn->exec($sql);																		
			
			
			$vartxt= $_SESSION["perfil"]. " ha escrito un mensaje";			 
            $sql2 = "INSERT INTO tblog (texto) VALUES ('$vartxt')";
			$conn->exec($sql2);								
			}
		catch(PDOException $e)
			{
			echo $sql . "<br>" . $e->getMessage();
			}				
	}

if (isset($_POST['volver'])) 
{
	header('location:index.php');
}

if (isset($_POST['ver'])) 
{
	//header('location:Paginar.php?codNOM='.$nombre);
	header('location:paginar.php');
}

if (isset($_POST['log'])) 
{
	if ( $_SESSION["perfil"]=="admin")header('location:paginarlog.php');
	else echo "NO tiene permisos de admin";
}

if (isset($_POST['estad'])) 
{
	if ( $_SESSION["perfil"]=="admin")header('location:paginarestadistica.php');
	else echo "NO tiene permisos de admin";
}

?>

<!DOCTYPE html>
<html>
<style>
form {
    border: 3px solid #f1f1f1;
}

.usuario  {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: none;
    background-color: #3CBC8D;
    color: white;
}
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}


.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
</style>
<body>

<h2>Comentarios</h2>

<form method="post">
 
  <div class="container">
    <label><b>Nombre Usuario</b></label>
    <input type="text" class="usuario" name="txtnombre" readonly value ='<?php echo $_SESSION["perfil"]?>'>

    <label><b>Comentarios</b></label><br>
    <textarea rows="4" cols="50" name="txtcomentarios">Escribe...</textarea>
        
    <button type="submit" name='alta'>Grabar Comentario</button>   
    <button type="submit" name='ver'>Ver Comentarios</button>   
    <button type="submit" name='volver'>Volver</button>   
    <button type="submit" name='log'>Ver LOG(admin)</button>   
    <button type="submit" name='estad'>ESTADISTICAS(admin)</button>   
  </div>

</form>

</body>
</html>
<?php
ob_end_flush();
?>

