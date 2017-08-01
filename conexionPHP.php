
<?php	
  $conn;	
  PDO("localhost","id2386758_carlos","carlos","id2386758_bbddcomentarios");	 
//  PDO("localhost","root","","bbddcomentarios"); 
  function PDO ($servername, $username, $password, $db)
  {     
	  try {
		 global $conn;				 
		 $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
	  // set the PDO error mode to exception
		 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 //echo "Conexion Establecida<br>"; 
		  }
 	 catch(PDOException $e)
		  {
		  echo "Error en la conexión: " . $e->getMessage();
		  }				  
  }
?>

