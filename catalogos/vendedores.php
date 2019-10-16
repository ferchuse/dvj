<?php
	
	include("../login/login_success.php");
	include("../conexi.php");
	include("../funciones/generar_select.php");
	$link = Conectarse();
	$menu_activo = "vendedores";
	
	
	$consulta = "SELECT * FROM vendedores";
	$result = mysqli_query($link, $consulta);
	
	if($result){
		while($fila = mysqli_fetch_assoc($result)){
			$registros[] = $fila;
		}
	}
	else{ 
		die("Error en la consulta $consulta". mysqli_error($link));
	}

?>

<!DOCTYPE html>
<html lang="es">
	
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		
    <title>Vendedores</title>
		
    <?php include("../styles_carpetas.php"); ?>
		
	</head>
	
	<body>
		
		<?php include("../menu_carpetas.php"); ?>
		
    <section class="container">
			<strong class="text-center">
				<h2>
					
					Vendedores 
					<button id="nuevo" type="button" class="btn btn-success pull-right" >
						<i class="fa fa-plus"></i> Nuevo
					</button>	
				</h2>
			</strong>
			<hr>
		</section>
    <br>
		
    <section class="container">
			<div class="row">
				<div class="col-4">
					<table class="table table-striped">
						<tr class="success">
							<td><strong>Id</strong></td>
							<td><strong>Nombre</strong></td>
							<td><strong>Acciones</strong></td>
						</tr>
						<?php foreach($registros AS $i=>$fila){	?>
							<tr class="">
								<td><?php echo $fila["id_vendedores"] ?></td> 
								<td><?php echo $fila["nombre_vendedores"] ?></td> 
								<td>
									<button class="btn btn-warning btn_editar" type="button" 
									data-id_registro="<?php echo $fila["id_vendedores"]?>"
									>
										<i class="fas fa-edit" ></i> Editar
									</button>
								</td> 
							</tr>
							<?php
							}
						?>
					</table>
				</div>
				
				<div class="col-8 collapse" id="reporte_comisiones">
					<div class="row">
						<div class="col-12">
							<h3 class="text-center">Reporte de Ventas </h3>
							<hr>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<form id="form_reportes" class="form-inline">
								<div class="form-group mr-2">
									<label for="fecha_inicio">Desde:</label>
									<input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?php echo $fa_inicial;?>">
								</div>
								<div class="form-group mr-2">
									<label for="fecha_fin">Hasta:</label>
									<input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?php echo $fa_final;?>">
								</div>
								<div class="form-group mr-2">
									<label for="id_departamentos">Vendedor:</label>
									<input type="hidden" name="id_vendedores" id="filtro_id_vendedores" >
									<input type="text" readonly  id="filtro_vendedores" class="form-control">
								</div>
								<div class="form-group mr-2">
									<button type="submit" class="btn btn-success" id="btn_buscar">
										<i class="fa fa-search"></i> Buscar
									</button>
								</div>
							</form>
						</div>
					</div>
					<div id="lista_ventas">
					</div>
				</div>
			</div>
		</section>
		
		<?php include('../scripts_carpetas.php'); ?>
		<?php include('form_vendedores.php'); ?>
		
	</body>
	<script>
		$("#nuevo").click(function(){
			$("#modal_edicion").modal("show")
		});
		$("#form_reportes").submit(listarComisiones);
		
		$(".btn_comisiones").click(function(){
			$("#filtro_id_vendedores").val($(this).data("id_vendedores"));
			$("#filtro_vendedores").val($(this).data("nombre_vendedores"));
			$("#reporte_comisiones").collapse("show");
			$("#lista_ventas").html("");
		});
		
		$("#form_edicion").submit(guardarRegistro);
		$(".btn_editar").click(cargarDatos);
		
		function listarComisiones(event){
			event.preventDefault();
			console.log("listarComisiones()");
			let $boton = $(this).find(":submit");
			let $icono = $(this).find(".fas");
			
			$boton.prop("disabled", true);
			$icono.toggleClass("fa-search fa-spinner fa-spin");			
			
			$.ajax({ 
				"url": "comisiones.php",
				"method": "POST",
				"data": $("#form_reportes").serialize()
				}).done( function alTerminar (respuesta){					
				
				$("#lista_ventas").html(respuesta);
				}).always(function(){
				
				$boton.prop("disabled", false);
				$icono.toggleClass("fa-search fa-spinner fa-spin");	
			});
		}
		
		function cargarDatos(event){
			console.log("event", event);
			let $boton = $(this);
			let $icono = $(this).find(".fas");
			let $id_registro = $(this).data("id_registro");				
			$boton.prop("disabled", true);
			$icono.toggleClass("fa-edit fa-spinner fa-spin");				
			$.ajax({ 
				"url": "../funciones/fila_select.php",
				"dataType": "JSON",
				"data": {
					"tabla": "vendedores",
					"id_campo": "id_vendedores",
					"id_valor": $id_registro						
				}
				}).done( function alTerminar (respuesta){					
				console.log("respuesta", respuesta);
				$boton.prop("disabled", false);
				$icono.toggleClass("fa-edit fa-spinner fa-spin"); 
				$("#modal_edicion").modal("show")
				$.each(respuesta.data, function(name, value){
					
					$("#" + name).val(value);                        
					
				})
				
			})
		}
		
		function guardarRegistro(event){
      event.preventDefault()
			console.log("guardarRegistro");
			
      let $boton = $(this).find(':submit');
			let $icono = $(this).find(".fas");
			
      $boton.prop("disabled", true);
			$icono.toggleClass("fa-save fa-spinner fa-spin");				
			
			$.ajax({ 
        "url": "guardar_vendedores.php",
        "dataType": "JSON",
        "method": "POST",
        "data": $("#form_edicion").serializeArray()
        }).done( function alTerminar (respuesta){
				console.log("respuesta", respuesta);
				if(respuesta.status == "success"){
					
					alertify.success(respuesta.mensaje);
				}
				else{
					alertify.error(respuesta.mensaje);
				}
				$("#modal_edicion").modal("hide");
				window.location.reload(true);
				}).always(function(){
				$boton.prop("disabled", false);
				$icono.toggleClass("fa-save fa-spinner fa-spin"); 
				
			});
			
		}		
	</script>
</html>		