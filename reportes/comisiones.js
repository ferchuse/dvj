
$("#form_reportes").submit(listarComisiones);

$(".btn_comisiones").click(function(){
	$("#filtro_id_vendedores").val($(this).data("id_vendedores"));
	$("#filtro_vendedores").val($(this).data("nombre_vendedores"));
	$("#reporte_comisiones").collapse("show");
	$("#lista_ventas").html("");
});

function listarComisiones(event){
	event.preventDefault();
	console.log("listarComisiones()");
	let $boton = $(this).find(":submit");
	let $icono = $(this).find(".fas");
	
	$boton.prop("disabled", true);
	$icono.toggleClass("fa-search fa-spinner fa-spin");			
	
	$.ajax({ 
		"url": "tabla_comisiones.php",
		"method": "POST",
		"data": $("#form_reportes").serialize()
		}).done( function alTerminar (respuesta){					
		
		$("#listar_registros").html(respuesta);
		$(".clickable").click(detalleComisiones);
		
		}).always(function(){
		
		$boton.prop("disabled", false);
		$icono.toggleClass("fa-search fa-spinner fa-spin");	
	});
}

function detalleComisiones(event){
	console.log("detalleComisiones", event);
	// let $boton = $(this);
	let  id_vendedores = $(this).data("id_vendedores");
	
	// $boton.prop("disabled", true);
	// $icono.toggleClass("fa-edit fa-spinner fa-spin");				
	$.ajax({
		"url": "historial_comisiones.php",
		"data": {
			"id_vendedores": id_vendedores,
			"fecha_inicial": $("#fecha_inicio").val(),
			"fecha_final": $("#fecha_fin").val()
			
		}
		}).done( function alTerminar (respuesta){
		console.log("respuesta", respuesta);
		$("#historial").html(respuesta);
		
		$("#modal_historial").modal("show");	
		
		
		}).always(function(){
		
		// $boton.prop("disabled", true);
		// $icono.toggleClass("fa-edit fa-spinner fa-spin");				
	});
}
