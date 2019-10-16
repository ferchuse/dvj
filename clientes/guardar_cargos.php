<?php
	header("Content-Type: application/json");
	include ("../conexi.php");
	$link = Conectarse();
	$respuesta = Array();
	
	
	
	$consulta = "INSERT INTO {$_POST["tipo"]} SET 
	id_clientes = '{$_POST["id_clientes"]}',
	fecha = '{$_POST["fecha"]}',
	importe = '{$_POST["importe"]}',
	concepto = '{$_POST["concepto"]}',
	saldo_anterior = '{$_POST["saldo_anterior"]}',
	saldo_restante = '{$_POST["saldo_restante"]}'
	
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