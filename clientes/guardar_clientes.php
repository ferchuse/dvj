<?php
	header("Content-Type: application/json");
	include ("../conexi.php");
	$link = Conectarse();
	$respuesta = Array();
	
	$consulta = "INSERT INTO clientes SET 
	id_clientes = '{$_POST["id_clientes"]}',
	nombre = '{$_POST["nombre"]}',
	correo = '{$_POST["correo"]}',
	telefono = '{$_POST["telefono"]}',
	direccion = '{$_POST["direccion"]}',
	id_vendedores = '{$_POST["id_vendedores"]}',
	activo = '{$_POST["activo"]}'
	
	ON DUPLICATE KEY UPDATE 
	
	nombre = '{$_POST["nombre"]}',
	correo = '{$_POST["correo"]}',
	telefono = '{$_POST["telefono"]}',
	direccion = '{$_POST["direccion"]}',
	id_vendedores = '{$_POST["id_vendedores"]}',
	activo = '{$_POST["activo"]}'
	
	";
	$result = mysqli_query($link, $consulta);
	
	$respuesta["consulta"] = $consulta;
	
	if($result){
		$respuesta["status"] = "success";
		$respuesta["mensaje"] = "Guardado";
		
	}	
	else{
		$respuesta["status"] = "error";
		$respuesta["mensaje"] = "Error $consulta  ".mysqli_error($link);		
	}
	
	echo json_encode($respuesta);
?>