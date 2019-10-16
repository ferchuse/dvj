<?php
	include("../login/login_success.php");
	include("../conexi.php");
	$link = Conectarse();
	$menu_activo = "principal";
	error_reporting(0);
	
	$consulta = "SELECT * FROM productos";
	$result = mysqli_query($link,$consulta);
	$num_rows = mysqli_num_rows($result);
	
	
	if(isset($_GET["id_clientes"])){
		$id_clientes = $_GET["id_clientes"];
		$nombre = $_GET["nombre"];
		
	}
	else{
		$id_clientes = "";
		$nombre = "";
		
	}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<style>
			<style>
				.tabla_totales .row{
		  	margin-bottom: 10px;
				}
				@media (max-width: 1366px){
				.tab-pane {
				display: block;
				overflow: auto;
				overflow-x: hidden;
				height: 380px;
				width: 100%;
				padding: 10px;				
				}		
				}
				@media (min-width: 1900px){
				.tab-pane {
				display: block;
				overflow: auto;
				overflow-x: hidden;
				height: 700px;
				width: 100%;
				padding: 10px;				
				}	
				
				}
			</style>  
		</style>
		
    <title>Nueva Venta</title>
    <?php include("../styles_carpetas.php");?>
	</head>
  <body>
		
		<?php include("../menu_carpetas.php");?>
		
		<div class="container-fluid hidden-print">
			
			<div class="row">
				<div class="col-sm-3">
					<input  hidden id="id_clientes" name="id_clientes" value="<?php echo $id_clientes?>">
					<label for="">Cliente:</label>
					<input id="nombre" name="nombre"   type="text" class="form-control" placeholder="Buscar" size="35"  value="<?php echo $nombre?>">
				</div>
				<form id="form_agregar_producto" class="form-inline" autocomplete="off">
					<div class="col-sm-2">
						<label for="">Código del Producto:</label>
						<input id="codigo_producto"   type="text" class="form-control" placeholder="Ingrese el codigo de barras" size="20">
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="">Descripción:</label>
							<input id="buscar_producto" placeholder="F10" autofocus type="text" class="form-control" size="50">
						</div>
					</div>
				</form>
				<div class="col-sm-2">
					<div class="radio">
						<label >
							<input class="tipo_precio" type="radio" name="precio" value="precio_menudeo" checked>
							Público 
						</label>
					</div>
					<div class="radio">
						<label  >
							<input class="tipo_precio" type="radio" name="precio" value="precio_medico">
							Médico
						</label>
					</div>
					<div class="radio">
						<label >
							<input class="tipo_precio" type="radio" name="precio" value="precio_mayoreo">
							Mayoreo
						</label>
					</div>
				</div>
				
			</div>
			
			
			<div class="row">
				<div class="col-md-12">
					<div class="tab-pane">
						<table id="tabla_venta" class="table table-bordered table-condensed">
							<thead class="bg-success">
								<tr>
									<th class="text-center">Cantidad</th>
									<th class="text-center">Unidad</th>
								<th class="text-center">Descripcion del Producto</th>
								<th class="text-center">Precio Unitario</th>
								<th class="text-center">Importe</th>
								<th class="text-center">Existencia</th>
								<th class="text-center">Acciones</th>
								</tr>
							</thead>
							<tbody >
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<br>
			<section id="footer">
				<div class="row">
					<div class="col-sm-9 text-right">
						<a class="btn btn-info btn-lg"  id="nueva_venta" href="index.php">
							Nueva Venta
						</a>
						<button class="btn btn-success btn-lg" FORM="" id="cerrar_venta">F12 - Guardar</button>
					</div>
					<div class="col-sm-1 h2">
						<strong>TOTAL:</strong>
					</div>
					<div class="col-sm-2 h1">
						<input readonly id="total" type="text" class="form-control input-lg text-right " value="0" name="total">
					</div>
				</div>
				
			</section>
			
		</div>
		
		<div id="ticket" class="visible-print">
			
		</div>
		<?php  include('../scripts_carpetas.php'); ?>
		
		<script src="ventas.js"></script>
		
	</body>
</html>				