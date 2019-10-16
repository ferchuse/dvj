<?php
include("../conexi.php");
include("../funciones/generar_select.php");
$link = Conectarse();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Clientes</title>

	<?php include("../styles_carpetas.php"); ?>
	<link rel="stylesheet" href="../css/lista_clientes.css">
</head>

<body>
	<!-- "Menú" -->
	<?php include("../menu_carpetas.php"); ?>

	<!-- "Encabezado" -->
	<div class="container-fluid">
		<!-- "Título, Filtros & Botones" -->
		<div class="row">
			<!-- "Título" -->
			<div class="col-sm-12">
				<h3 class="text-center">Clientes <span class="badge badge-success" id="contar_registros">0</span></h3>
			</div>

			<!-- Filtro: "Buscar Clientes" -->
			<div class="col-sm-3">
				<input autocomplete="off" disabled type="search" class="form-control" data-indice="1" id="buscar" placeholder="Buscar Cliente">
			</div>

			<!-- Filtros: "Estatus Clientes" & "Vendedores" -->
			<form class="col-sm-7 form-inline" id="form_filtros">
				<input type="hidden" id="sort" name="sort" value="nombre">
				<input type="hidden" id="order" name="order" value="ASC">
				<div class="col-sm-4 form-group">
					<label for="estatus_clientes">Estatus</label>
					<select class="form-control" name="estatus_clientes" id="estatus_clientes">
						<option value="todos">TODOS</option>
						<option value="1">ACTIVO</option>
						<option value="0">INACTIVO</option>
					</select>
				</div>
				<div class="col-sm-6 form-group">
					<label for="id_vendedores">Vendedor</label>
					<?php echo generar_select($link, "vendedores", "id_vendedores", "nombre_vendedores", true); ?>
				</div>
				<div class="col-sm-2 text-left">
					<button type="submit" class="col-sm-7 btn btn-primary float-left text-center" id="">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</form>

			<!-- Botón: "Nuevo" -->
			<div class="col-sm-2 text-right">
				<button type="button" class="btn btn-success float-right" id="btn_nuevo">
					<i class="fa fa-plus"></i> Nuevo
				</button>
			</div>
		</div>

		<!-- Línea -->
		<hr class="linea">

	</div>

	<!-- Tabla: "Lista Registros" -->
	<div class="container-fluid text-center">
		<div class="table-responsive" id="lista_registros"></div>
	</div>

	<!-- "Historial" -->
	<div id="historial"></div>

	<!-- "Scripts" & "Forms" -->
	<?php include('../scripts_carpetas.php'); ?>
	<?php include('form_cargos.php'); ?>
	<?php include('form_clientes.php'); ?>
	<script src="clientes.js"></script>
	<script src="cargos.js"></script>

	<!-- "Filtros" -->
	<script>
		var boton, icono;
		$(document).ready(onLoad);

		function onLoad() {
			console.log("onLoad");
			$("#form_filtros").submit(listarClientes);
		}

		function listarClientes(event) {
			event.preventDefault();
			boton = $(this).find(":submit");
			icono = boton.find("i");

			boton.prop("disabled", true);
			icono.toggleClass("fa-search fa-spinner fa-spin");

			$.ajax({
				"url": "tabla_clientes.php",
				"data": $("#form_filtros").serialize()
			}).done(alCargar);
		}

		function alCargar(respuesta) {
			$("#lista_registros").html(respuesta);
			$('#buscar').prop("disabled", false);
			$('#buscar').keyup(buscarCliente);
			$('.btn_editar').click(editarCliente);
			$('.btn_historial').click(cargarHistorial);

			$('.sort').click(ordenarTabla);
			contarRegistros();

			boton.prop("disabled", false);
			icono.toggleClass("fa-search fa-spinner fa-spin");
		}
	</script>
</body>

</html>