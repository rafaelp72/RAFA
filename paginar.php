<?php
ob_start();
session_start(); // $_SESSION["perfil"] de validacion.php a comentarios.php  y a paginar.php
?>
<!DOCTYPE html>
<html>
<head>
<style>
form {border: 3px solid #f1f1f1;}


table {margin: auto; 
	    font-size: 12px;  	   
		text-align: left;    
		border-collapse: collapse; }

th {  font-size: 13px;     font-weight: normal;     padding: 5px;     background: #b9c9fe;
    border-top: 4px solid #aabcfe;    border-bottom: 1px solid #fff; color: #039; }

td {    padding: 3px;     background: #e8edff;     border-bottom: 1px solid #fff;
    color: #669;    border-top: 1px solid transparent; }

tr:hover td { background: #d0dafd; color: #339; }

a {text-align:center;}

.buscar{
    width: 70%;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: #D4DFFF;
    background-position: 10px 10px; 
    padding: 12px 20px 12px 40px;
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

button:hover {opacity: 0.8;}

.pagination {
    display: inline-block;
	margin: 0 0 0 350px;
	
}

.pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
	text-align:center;
}

.pagination a.active {
    background-color: #4CAF50;
    color: white;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>
</head>
<body>

<form >
 <h3>Usuario conectado: <?php echo $_SESSION["perfil"]?></h3>
 <input type="text" class="buscar" name='txtbuscar' placeholder="Buscar ..." >
 <button type="submit"  name='buscar'>Buscar</button>
 <button type="submit"  name='exportar'>Exportar PDF</button>
 <button type="submit" name='volver'>Volver a Index</button>  
</form>

<?php 
  echo "<h2>Tabla Comentarios</h2>";                   
if (!isset($_GET['pagina'])){$pagina=1; }
else{$pagina = $_GET['pagina'];}

if (isset($_GET['volver'])) {header('location:index.php');}

if (isset($_GET['exportar']))
{
 header('location:p.php'); 
 }
include 'conexionPHP.php';

	
	$url= basename($_SERVER['PHP_SELF']); //se llama a si mismo para paginar
	
	$sth = $conn->prepare('SELECT count(*) as total from tbcomentarios');
	$sth->execute();
	$num_total_registros = $sth->fetchAll()[0]['total']; // funciona la linea
	
	$TAMANO_PAGINA = 5;
	
	
	if ($pagina==0) {$inicio = 0;$pagina = 1; }
	else {$inicio = ($pagina - 1) * $TAMANO_PAGINA;}
			
	$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);	
					
//**************************PAGINAR******************************************	

if(isset($_GET['buscar'])){
   $clave=$_GET['txtbuscar'];  
$consulta="SELECT tbcomentarios.idcomentario, tbcomentarios.idusuario, tbusuarios.Nombre , tbcomentarios.Comentario, tbcomentarios.Fecha FROM tbcomentarios INNER JOIN tbusuarios on tbcomentarios.idusuario = tbusuarios.idusuario WHERE tbusuarios.Nombre LIKE '%".$clave."%' OR tbcomentarios.Comentario LIKE '%".$clave."%' LIMIT $inicio,$TAMANO_PAGINA" ;}
else {
$consulta="SELECT tbcomentarios.idcomentario, tbcomentarios.idusuario, tbusuarios.Nombre , tbcomentarios.Comentario, tbcomentarios.Fecha FROM tbcomentarios INNER JOIN tbusuarios on tbcomentarios.idusuario = tbusuarios.idusuario LIMIT $inicio,$TAMANO_PAGINA";
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
	

    echo "<table border='2'>
    <tr>
    <th>IDComentario</th>
    <th>IDUsuario</th>
    <th>Nombre</th>
    <th>Comentario</th>
    <th>Fecha</th>
    
    </tr>";

    foreach($result as $row)
    	{
		echo "<tr>";
		$IDC= $row['idcomentario'];
		$NOM= $row['Nombre'];
		echo "<td>" . $row['idcomentario'] . "</td>";
		echo "<td>" . $row['idusuario'] . "</td>";
		echo "<td>" . $row['Nombre'] . "</td>";
		echo "<td>" . $row['Comentario'] . "</td>";
		echo "<td>" . $row['Fecha'] . "</td>"; 
						
		//JAVASCRIPT PARA CONFIRMAR BORRADO Y LLAMAR A FUNCION
		
		echo "<td><a href=" . chr(34) . "javascript:confirmar(".$IDC.",'" .
                     $_SESSION["perfil"]. "')" . chr(34) . ">Eliminar</a></td>";
				
		}
   echo "</tr>";
   echo "</table>";


// tabla borrar desbloquear

 echo "<hr><h2>Tabla Usuarios</h2>";
$consulta="SELECT idusuario,Nombre,Intentos,Bloqueado FROM tbusuarios where Nombre <> 'admin' GROUP BY Nombre";

	
$query = $conn->prepare($consulta);
$query->execute();		
$result = $query->fetchAll();	

 echo "<table border='2'>
    <tr>    
    <th>Nombre</th>
    <th>Intentos</th>
    <th>Bloqueado</th>

    
    </tr>";

    foreach($result as $row)
    	{
		echo "<tr>";
		$IDU= $row['idusuario'];
		$NOM= $row['Nombre'];
				
		echo "<td>" . $row['Nombre'] . "</td>";
		echo "<td>" . $row['Intentos'] . "</td>";
		echo "<td>" . $row['Bloqueado'] . "</td>"; 
						
		//JAVASCRIPT PARA CONFIRMAR BORRADO Y LLAMAR A FUNCION
		
		echo "<td><a href=" . chr(34) . "javascript:confirmar2(".$IDU.",'" .
                     $_SESSION["perfil"]. "')" . chr(34) . ">Eliminar</a></td>";

 							 
		echo "<td><a href='Desbloquear.php?cod=$IDU'>Desbloquear</a></td>";		
		}
   echo "</tr>";
   echo "</table>";



   $conn = null;   
      
?>
 <script>
  	
		function confirmar(id, perf)
		{
		ventana=confirm("Seguro que quieres Eliminarlo"); 
		if (ventana==true & perf=="admin") 
			{ 
 				location.href="borrar.php?cod="+id;
			}
		else 
			{
			return false;
		    }
		}
		
		function confirmar2(id, perf)
		{
		ventana=confirm("Seguro que quieres eliminar el usuario"); 
		if (ventana==true & perf=="admin") 
			{ 
 				location.href="borrarusuario.php?cod="+id;
			}
		else 
			{
			return false;
		    }
		}
  </script>
</body>
</html>
<?php
ob_end_flush();
?>