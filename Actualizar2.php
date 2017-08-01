<?php
include 'conexionPHP.php';
PDO("localhost","root","","bbddcomentarios");
$ID = $_GET['cod'];
$query = $conn->prepare("SELECT * FROM tbusuarios where idusuario='$ID'");	
$query->execute();		
$result = $query->fetchAll(); //como solo es un campo tb sirve FETCH() y se seleccionan los campos con $result['Idusuario'];

 foreach($result as $row)
    	{		
		//$ID1= $row['idusuario'];
		$Usuario1 = $row['Nombre'] ;
		$Pass1 = $row['Password'] ;
		$Email1 = $row['Email'] ;
		$Fecha1 = $row['Fecha'] ; 
		$Perfil1 = $row['Perfil'] ; 
		
		}

	
if (isset($_POST['actualizar']))
{				
		$nom=$_POST['txtnombre'];
		$pass=$_POST['txtpass'];
		$email=$_POST['txtemail'];	
		$fecha=str_replace("/","-",($_POST['txtfecha']));
		$fecha=date('Ymd', strtotime($fecha));
		
		$perfil=$_POST['txtperfil'];		
		
						
		try {						
	        $sql = "UPDATE tbusuarios SET Nombre='$nom',Password='$pass',Email='$email',Fecha=$fecha,Perfil='$perfil' WHERE idusuario=$ID";
   
		    $stmt = $conn->prepare($sql);
		    $stmt->execute();
		    //echo $stmt->rowCount() . " Registro actualizado";
		    }
		catch(PDOException $e)
    		{
		    echo $sql . "<br>" . $e->getMessage();
		    }		
}
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
    <h1>Visitas</h1>      
  </div>

<ul class="breadcrumb">
    <li class="active">MODIFICAR DATOS DE USUARIO</li>   
     <li ><a href="Alta2.php">Alta de usuarios</a></li>    
    <li ><a href="paginar2.php">Ver tabla</a></li>  
    <li><span class="glyphicon glyphicon-user"></span><?php echo ' ' .$ID?></li>       
  </ul>

  
  <form class="form-horizontal" method="post"">
  
  <div class="form-group">
      <label class="control-label col-sm-2" for="email">Nombre:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="txtnombre"  value ='<?php echo $Usuario1?>'>
      </div>
    </div>
  
   <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-10">          
        <input type="password" class="form-control" name="txtpass" value ='<?php echo $Pass1?>'>
      </div>
    </div>
  
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Fecha:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="txtfecha" value ='<?php echo $Fecha1?>'>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="txtemail" value ='<?php echo $Email1?>'>
      </div>
    </div>
    
   <div class="form-group">
      <label class="control-label col-sm-2" for="email">Perfil:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="txtperfil" value ='<?php echo $Perfil1?>'>
      </div>
    </div>
    
    
   <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" name="actualizar">Aceptar</button>
      </div>
   </div>
  </form>
</div>
</div> 
<!--fin div container-->
</body>
</html>

