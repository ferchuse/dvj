<?php
	
	include("../login/login_success.php");
	include("../conexi.php");
	include("../funciones/generar_select.php");
	$link = Conectarse();
	
	
	$dt_fecha_inicial = new DateTime("first day of this month");
	$dt_fecha_final = new DateTime("last day of this month");
	
	$fa_inicial = $dt_fecha_inicial->format("Y-m-d");
	$fa_final = $dt_fecha_final->format("Y-m-d");
	
?>

<!DOCTYPE html>
<html lang="es">
	
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		
    <title>Reporte de Comisiones</title>
		
    <?php include("../styles_carpetas.php"); ?>
		<style>
			.clickable{
			cursor:pointer;
			}
		</style>
	</head>
	
	<body>
		<?php include("../menu_carpetas.php");?>
		<div class="container-fluid">
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">Reporte de Comisiones</h3>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form id="form_reportes" class="form-inline">
						<div class="form-group mr-2">
							<label for="fecha_inicio">Desde:</label>
							<input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?php echo $fa_inicial;?>">
						</div>
						<div class="form-group mr-2">
							<label for="fecha_fin">Hasta:</label>
							<input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?php echo $fa_final;?>">
						</div>
						<button type="submit" class="btn btn-success" id="btn_buscar">
							<i class="fa fa-search"></i> Buscar
						</button>
						
					</form>
				</div>
			</div>
			<hr>
			<div class="row text-center" >
				<div class="col-sm-8 " id="listar_registros">
					
				</div>
			</div>
			
		</div >
		
		<div id="historial">
		</div>
		<?php  include('../scripts_carpetas.php'); ?>
		
		<script src="comisiones.js"></script>
	</body>
	
	
</html>		