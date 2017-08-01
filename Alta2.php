<?php
session_start();
?>
<!DOCTYPE html>
<html>
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
  <div class="jumbotron">
    <h1 align="center">Bases de datos</h1>      
  </div>

<ul class="breadcrumb">
    <li class="active">ALTA DE USUARIOS</li>          
    <li ><a href="paginar2.php">ver tabla</a></li>  
    <li><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION["perfil"]?></li>       
  </ul>

  
  <form class="form-horizontal" method="post"">
  
  <div class="form-group">
      <label class="control-label col-sm-2" for="email">Nombre:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="txtnombre">
      </div>
    </div>
  
   <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-10">          
        <input type="password" class="form-control" name="txtpass">
      </div>
    </div>
  
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Fecha:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="txtfecha">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="txtemail">
      </div>
    </div>
    
   <div class="form-group">
      <label class="control-label col-sm-2" for="email">Perfil:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="txtperfil">
      </div>
    </div>
    
    
   <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" name="alta">Aceptar</button>
      </div>
   </div>
  </form>
</div>
</div> 
<!--fin div container-->
</body>
</html>

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


