<?php
session_start();$_SESSION["perfil"]="admin";
include 'conexionPHP.php';

$query = $conn->prepare('SELECT idusuario, Nombre from tbusuarios');
$query->execute();	
$result = $query->fetchAll();	
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

	 <div class="panel panel-info">
      <div class="panel-heading" align="center">TABLA DE USUARIOS</div>
    </div>
    
  
 <ul class="breadcrumb">
    <li class="active">CONSULTA DE TABLAS</li>   
    <li ><a href="alta2.php">Alta de usuarios</a></li>        
    <li ><span class="glyphicon glyphicon-user" ></span><?php echo $_SESSION["perfil"]?></li>       
  </ul>
  
  <form class="form-horizontal" >
  
  <div class="form-group row">
        <div class="col-xs-4">  
 		<label>Nombre Empleado</label>
		<select class="form-control" name="combo">
        <OPTION selected="selected">Todos
		<?php foreach ($result as $row) {
			echo '<option value="'.$row['Nombre'].'">'.$row['Nombre'].'</option>';}
		?>
	    </select>
      </div>  
  
      <div class="col-xs-4">
        <label>Nombre</label>
        <input class="form-control" name="txtnom" type="text">
      </div>
      
      <div class="col-xs-4">
        <label>Email</label>
        <input class="form-control" name="txtmail" type="text">
      </div>
      
      <div class="col-xs-4">
         <label> </label>            
         <button type="submit" class="btn btn-primary btn-sm" name="filtrar">Filtrar</button>   
      </div>
           
    </div>
    
  </form>
     
</div> 


<?php                   
if (!isset($_GET['pagina'])){$pagina=1; }
else{$pagina = $_GET['pagina'];}

//include 'conexionPHP.php';
//PDO("localhost","root","","bbddcomentarios");
	
	$url= basename($_SERVER['PHP_SELF']); //se llama a si mismo para paginar
	
	$sth = $conn->prepare('SELECT count(*) as total from tbusuarios');
	$sth->execute();
	$num_total_registros = $sth->fetchAll()[0]['total']; // funciona la linea
	
	$TAMANO_PAGINA = 5;
	
	
	if ($pagina==0) {$inicio = 0;$pagina = 1; }
	else {$inicio = ($pagina - 1) * $TAMANO_PAGINA;}
			
	$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);	
					
//**************************PAGINAR******************************************	
/*$consulta2="SELECT tbcomentarios.idcomentario, tbcomentarios.idusuario, tbusuarios.Nombre , tbcomentarios.Comentario, tbcomentarios.Fecha FROM tbcomentarios inner JOIN tbusuarios on tbcomentarios.idusuario = tbusuarios.idusuario where 1=1";*/

$consulta="SELECT idusuario,Nombre,Password,Email,Fecha,Perfil FROM tbusuarios where 1=1";

if(isset($_GET['filtrar'])){
   $claveMAIL=$_GET['txtmail'];   
   $claveNOM=$_GET['txtnom'];
   $claveCOM=$_GET['combo']; 
  
   if ($claveCOM!="Todos"){
	   $consulta=$consulta . " and Nombre=". chr(34) . $claveCOM . chr(34);
				}   
   if ($claveNOM!=""){
	   $consulta=$consulta . " and Nombre like " . chr(34) . $claveNOM . "%". chr(34);
				}	
   if ($claveMAIL!=""){
		$consulta=$consulta . " and Email like " . chr(34) . "%". $claveMAIL . "%" . chr(34);
				}    
}
	
$query = $conn->prepare($consulta);
$query->execute();		
$result = $query->fetchAll();	
		
	echo "<div class='pagination'>";
	if ($total_paginas > 1) 
	{
    if ($pagina != 1)
	
      echo '<a href="'.$url.'?pagina='.($pagina-1).'"><</a>';
      for ($i=1;$i<=$total_paginas;$i++) 
	  {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
           // echo '  <a href="#"'.$pagina.'></a>  ';
		    echo  '<a class="active" href="#">'.$pagina.'</a>  ';
      
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
            echo '  <a href="'.$url.'?pagina='.$i.'">'.$i.'</a>  ';
      }
      if ($pagina != $total_paginas)
         echo '<a href="'.$url.'?pagina='.($pagina+1).'">></a>';
		 
	echo "</div>";
	}
	
    echo "<table class='table'>
    <tr>   
    <th>IDusuario</th>
    <th>Nombre</th>
    <th>Password</th>
    <th>Email</th>
    <th>Fecha</th>
    <th>Perfil</th>
    
    </tr>";

    foreach($result as $row)
    	{
		echo "<tr>";
		$ID= $row['idusuario'];
		$NOM= $row['Nombre'];		
		echo "<td>" . $row['idusuario'] . "</td>";
		echo "<td>" . $row['Nombre'] . "</td>";
		echo "<td>" . $row['Password'] . "</td>";
		echo "<td>" . $row['Email'] . "</td>";
		echo "<td>" . $row['Fecha'] . "</td>";
		echo "<td>" . $row['Perfil'] . "</td>"; 
						
		//JAVASCRIPT PARA CONFIRMAR BORRADO Y LLAMAR A FUNCION
		
		
		//mas maneras de hacerlo
		//echo "<td><a href=" . chr(34) . "javascript:confirmar(".$ID.",'" .
          //           $_SESSION["perfil"]. "')" . chr(34) . ">Eliminar</a></td>";
		//echo "<td><a href='Actualizar2.php?cod=$ID' class='btn btn-primary'>Acr</a></td>";
		
		echo "<td><div class='btn-group'><input type='submit' class='btn btn-warnig btn-sm' id ='a' value='Eliminar' onclick = 'confirmar(".$ID.");'>";
		
		echo "<input type='submit' class='btn btn-primary btn-sm' id ='b' value='Actualizar' onclick = 'funcionA(".$ID.");'></div></td>";

		}
   echo "</tr>";
   echo "</table>";

  $conn = null;   
    
	
	  
?>
 <script>
  	function funcionA(id){location.href="actualizar2.php?cod="+id; }
	
	function confirmar(id)
		{
		ventana=confirm("Seguro que quieres Eliminarlo"); 
		if (ventana==true) 
			{ 
 				location.href="borrar2.php?cod="+id;
			}
		else 
			{
			return false;
		    }
		}
		
  </script>
</body>
</html>
