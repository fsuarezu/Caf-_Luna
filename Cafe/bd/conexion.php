<?php 
	$host = "localhost"; 
	$user = "root"; 
	$pass = ""; 
	$db = "cafe_luna"; 
	
	$conexion = new mysqli($host, $user, $pass, $db); 
	if ($conexion->connect_error) 
	{ 
		die("Error de conexión: " . $conexion->connect_error); 
	} 
?>
