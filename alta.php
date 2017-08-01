<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html>
<style>
form {
    border: 3px solid #f1f1f1;
}

input[type=text] {
    width: 100%;
    padding: 6px 10px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;	
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 7px 10px;
    margin: 6px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.container {
    padding: 10px;
}

}
</style>
<body>

<h2>Formulario</h2>

<form method="post" enctype="multipart/form-data"> 
  <div class="container">
    <label><b>Usuario</b></label>
    <input type="text" name="txtnombre" >
    <label><b>Password</b></label>
    <input type="text" name="txtpass" >
    <label><b>email</b></label>
    <input type="text" name="txtemail" >
    <label><b>fecha</b></label>
    <input type="text" name="txtfecha" >   
    <label><b>perfil</b></label>
    <input type="text" name="txtperfil" >  
                                  
    
    <button type="submit" name='alta'>Alta Registro</button>   

  </div>
</form>

<?php
include 'conexionPHP.php';

if (isset($_POST['alta']))
	{				
		$nom=$_POST['txtnombre'];
		$pass=$_POST['txtpass'];
		$email=$_POST['txtemail'];		
		$fecha=str_replace("/","-",($_POST['txtfecha']));
		$fecha=date('Ymd', strtotime($fecha));
		$perfil=$_POST['txtperfil'];	
		PDO("localhost","root","","bbddcomentarios");
		try {
			$sql = "INSERT INTO tbusuarios (Nombre,Password,Email,Fecha,Perfil)
			VALUES ('$nom','$pass','$email',$fecha,'$perfil')";			
			$conn->exec($sql);	
			$last_id=$conn->lastInsertId();	
			
			$vartxt= $nom. " ha sido dado de alta";			 
            $sql2 = "INSERT INTO tblog (texto) VALUES ('$vartxt')";
			$conn->exec($sql2);
			 
			$conn = null;																
			echo "Registro creado";												
			}
		catch(PDOException $e)
			{
			echo $sql . "<br>" . $e->getMessage();
			}	
	// se dirige a validar para luego añadir comentarios
	//$pass=$_POST['txtpass'];
	//$email=$_POST['txtemail'];
	$_SESSION["perfil"] = $nom;	
	header('location:comentarios.php?codID='.$last_id); 
	//header('location:validacion.php?cod='.$email.'&cod2='.$pass); 	
	}
?>

</body>
</html>
<?php
ob_end_flush();
?>