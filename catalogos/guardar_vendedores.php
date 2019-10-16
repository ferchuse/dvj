<?php
	include ('../conexi.php');
	$link = Conectarse();
	
	
	$respuesta= array();
	
	$query = "INSERT INTO vendedores
	SET
	id_vendedores = '{$_POST["id_vendedores"]}',
	nombre_vendedores = '{$_POST["nombre_vendedores"]}',
	password = '{$_POST["password"]}'
	
	ON DUPLICATE KEY UPDATE 
	
	id_vendedores = '{$_POST["id_vendedores"]}',
	nombre_vendedores = '{$_POST["nombre_vendedores"]}',
	password = '{$_POST["password"]}'
	
	";
	$result = mysqli_query($link, $query);
	
	if($result){
		$respuesta["status"] = "success";
		$respuesta["mensaje"] = "Se guardó correctamente";
	}
	else{
		$respuesta["status"] = "error";
		$respuesta["mensaje"] = "Error en la consulta $query". mysqli_error($link);
		
	}
	
	echo json_encode($respuesta);
?>