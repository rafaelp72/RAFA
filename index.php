<?php
ob_start();
session_start(); // $_SESSION["perfil"] de validacion.php a comentarios.php  y a paginar.php
//if (isset($_GET[$_SESSION["contador"]]) or $_SESSION["contador"]==0) $_SESSION["contador"]=1;
?>
<!DOCTYPE html>
<html>
<style>
form {border: 3px solid #f1f1f1;}

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

button:hover { opacity: 0.8;}


.container { padding: 16px;}

span.psw {float: right;padding-top: 16px;}

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

<h2>Formulario</h2>

<form method="post">
 
  <div class="container">
    <label><b>Email</b></label>
    <input type="text" name="txtemail" >

    <label><b>Password</b></label>
    <input type="password" name="txtpass" >
        
    <button type="submit" name='aceptar'>Validar/Ver comentarios</button>   
    <button type="submit" name='registrar'>Alta nuevo registro</button>   
  </div>

</form>

<?php
$cont2=0;
if (isset($_POST['registrar'])){header('location:alta.php');}

if (isset($_POST['aceptar']))
{	$pass=$_POST['txtpass'];
	$email=$_POST['txtemail'];	
	include 'conexionPHP.php';

	
	if (isset($_GET['cod'])){$email = $_GET['cod'];}
	if (isset($_GET['cod2'])){$pass = $_GET['cod2'];}
	
	$query = $conn->prepare("SELECT * FROM tbusuarios where Email='$email'");	
	$query->execute();		
	$result = $query->fetch();
	$var0 = $result['Nombre'];
	$var1 = $result['Idusuario'];
	$var2 = $result['Intentos'];
	$var3 = $result['Bloqueado'];
	
	$_SESSION["perfil"] = $result['Nombre'];		
	
	if ($result)	//1 result
	{     
	  $query = $conn->prepare("SELECT * FROM tbusuarios where Email='$email' and Password='$pass'");	
	  $query->execute();		
	  $result = $query->fetch();
     		 
	  if (!$result)	//2 result
	  {			  				 
		  if ($var2 < 3)						
		  {			 			
			 $var2++;
			 $sql = "UPDATE tbusuarios SET Intentos='$var2' WHERE Email='$email'";	
 			 echo $var2. " Intentos";   				
			 
 			 $vartxt= $var0 . " ha tenido " .$var2. " intento/s fallido/s";			 
			 $sql2 = "INSERT INTO tblog (texto) VALUES ('$vartxt')";											

		  }		    
		  else
			{			  
			 $sql = "UPDATE tbusuarios SET Bloqueado='1',Intentos='3' WHERE Email='$email'";
			 echo "Usuario Bloqueado!!!";	
			  
             $vartxt= $var0. " ha sido bloqueado";			 
			 $sql2 = "INSERT INTO tblog (texto) VALUES ('$vartxt')";			

			}	
	 $stmt = $conn->prepare($sql);
	 $stmt->execute();	
	 
	 $conn->exec($sql2); //inserta en tabla tblog			 	 
	}//2 result
	else
	{		
		 if ($var3 == 0)
		  {
             $vartxt= $var0. " se ha conectado";			 
			 $sql2 = "INSERT INTO tblog (texto) VALUES ('$vartxt')";
			 $conn->exec($sql2);
			 header('location:comentarios.php?codID='.$var1); 
			 $conn = null;			
		  }
	 echo "Usuario Bloqueado!!!";	  
	}
	}//1 result
							
}//boton

?>

</body>
</html>
<?php
ob_end_flush();
?>