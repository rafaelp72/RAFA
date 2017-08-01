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
	    font-size: 18px;  	   
		text-align: center;    
		border-collapse: collapse; }

th {  font-size: 20px; font-weight: normal;  padding: 5px;     background: #4CAF50;
    border-top: 4px solid #4CAF50;    border-bottom: 1px solid #4CAF50; color: #FFF; }

td {    padding: 3px;     background: #e8edff;     border-bottom: 1px solid #fff;
    color: #669;    border-top: 1px solid transparent; }

tr:hover td { background: #00DFAA; color: #339; }

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

 <button type="submit" name='volver'>Volver a Index</button>  
</form>

<?php 
                    
if (!isset($_GET['pagina'])){$pagina=1; }
else{$pagina = $_GET['pagina'];}

if (isset($_GET['volver'])) {header('location:index.php');}

include 'conexionPHP.php';

	
	$url= basename($_SERVER['PHP_SELF']); //se llama a si mismo para paginar
	
	$sth = $conn->prepare('SELECT count(*) as total from tbcomentarios GROUP BY tbcomentarios.idusuario');
	$sth->execute();
	$num_total_registros = $sth->fetchAll()[0]['total']; // funciona la linea
	
	$TAMANO_PAGINA = 5;
	
	
	if ($pagina==0) {$inicio = 0;$pagina = 1; }
	else {$inicio = ($pagina - 1) * $TAMANO_PAGINA;}
			
	$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);	
					
//**************************PAGINAR******************************************	

$consulta="SELECT tbcomentarios.idusuario, tbusuarios.Nombre,COUNT(tbcomentarios.Comentario) AS Total FROM tbcomentarios
LEFT JOIN tbusuarios ON tbcomentarios.idusuario = tbusuarios.idusuario 
GROUP BY tbcomentarios.idusuario order by Total DESC LIMIT $inicio,$TAMANO_PAGINA";	

	
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
    <th>Nombre</th>
	 <th>TOTAL</th>
    </tr>";

    foreach($result as $row)
    	{
		echo "<tr>";					
		echo "<td>" . $row['Nombre'] . "</td>";
		echo "<td>" . $row['Total'] . "</td>";
									
		}
   echo "</tr>";
   echo "</table>";

   $conn = null;   
      
?>

</body>
</html>
<?php
ob_end_flush();
?>