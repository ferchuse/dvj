

$(document).ready(onLoad);


function onLoad() {
	console.log("onLoad");
	$("#btn_nuevo").click( function nuevoCliente(){
		console.log("nuevoCliente");
		$('#form_clientes')[0].reset();
		
		$("#modal_clientes").modal("show");
		
	});
	
	
	// $('#mostrar_inactivos').change(mostarInactivos);
	
	$('#buscar').prop("disabled", false);
	$('#buscar').keyup(buscarCliente);
	$('.btn_editar').click(editarCliente);
	$('.btn_historial').click(cargarHistorial);
	$('#form_clientes').submit(guardarCliente);
	$('.sort').click(ordenarTabla);
	
}


function ordenarTabla() {
	console.log("ordenarTabla");
	
	if(	$("#order").val() ==  "ASC"){
		$("#order").val("DESC");
	}
	else{
		$("#order").val("ASC");
	}
	
	$("#sort").val($(this).data("columna"));
	$('#form_estatus_clientes').submit();
}
function contarRegistros() {
	console.log("contarRegistros");
	$("#contar_registros").text($("#lista_registros tbody tr:visible").length);
}
function buscarCliente() {
	var indice = $(this).data("indice");
	var query = $(this).val();
	var num_rows = buscar(query, 'lista_registros', indice);
	contarRegistros();
	if (num_rows == 0) {
		$('#mensaje').html("<div class='alert alert-warning text-center'><strong>No se ha encontrado.</strong></div>");
		} else {
		$('#mensaje').html('');
	}
}

function buscar(filtro, table_id, indice) {
	var filter, table, tr, td, i;
	filter = filtro.toUpperCase();
	table = document.getElementById(table_id);
	tr = table.getElementsByTagName("tr");
	
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[indice];
		if (td) {
			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
				} else {
				tr[i].style.display = "none";
			}
		}
	}
	var num_rows = $(table).find('tbody tr:visible').length;
	return num_rows;
}


function cargarHistorial(){
	
	let boton = $(this);
	let icono = boton.find(".fas");
	let id_clientes = boton.data("id_registro");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-history fa-spinner fa-spin");
	
	$.ajax({
		url: "modal_historial.php",
		data: {
			
			"id_clientes": id_clientes
			
		}
		
		}).done(function(respuesta){
		console.log("respuesta",respuesta);
		
		$("#historial").html(respuesta);
		$("#modal_historial").modal("show");
		$(".btn_borrar_transaccion").click(borrarTransaccion);
		
		
		}).fail(function(xht, error, errnum){
		
		alertify.error("Error", errnum);
		}).always(function(){
		boton.prop("disabled", false);
		icono.toggleClass("fa-history fa-spinner fa-spin");
		
	});
	
	
}


function borrarTransaccion(){
	console.log("borrarTransaccion");
	let boton = $(this);
	let icono = boton.find(".fas");
	let id_transaccion = boton.data("id_registro");
	let tipo = boton.data("tipo");
	let tabla = tipo == "CARGO" ? "ventas": "abonos";
	let id_campo = tipo == "CARGO" ? "id_cargos": "id_abonos";
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-trash fa-spinner fa-spin");
	
	$.ajax({
		url: "../funciones/fila_delete.php",
		method: "POST",
		dataType: "JSON",
		data: {
			"tabla": tabla,
			"id_campo": "id_ventas",
			"id_valor": id_transaccion
			
		}
		
		}).done(function(respuesta){
		console.log("respuesta",respuesta);
		if(respuesta.estatus == "error"){
			alertify.error(error.error);
			
		}
		else{
			boton.closest("tr").remove();
			
		}
		boton.closest("tr").remove();
		
		}).fail(function(xht, error, errnum){
		
		alertify.error("Error", errnum);
		}).always(function(){
		boton.prop("disabled", false);
		icono.toggleClass("fa-trash fa-spinner fa-spin");
		
	});
	
	
}
function editarCliente(){
	
	let boton = $(this);
	let icono = boton.find(".fas");
	let id_clientes = boton.data("id_registro");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-edit fa-spinner fa-spin");
	
	$.ajax({
		url: "../funciones/fila_select.php",
		dataType: "JSON",
		data: {
			tabla: "clientes",
			id_campo: "id_clientes",
			id_valor: id_clientes
		}
		
		}).done(function(respuesta){
		console.log("respuesta",respuesta);
		if(respuesta.encontrado == 1){
			$.each(respuesta.data, function (name, value){
				$("#form_clientes #" + name).val(value);
			});
			
			$("#modal_clientes").modal("show");
			
		}
		}).fail(function(xht, error, errnum){
		
		alertify.error("Error", errnum);
		}).always(function(){
		boton.prop("disabled", false);
		icono.toggleClass("fa-edit fa-spinner fa-spin");
		
	});
	
	
}


function guardarCliente(){
	
	event.preventDefault();
	
	let boton = $(this).find(":submit");
	let icono = boton.find(".fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-save fa-spinner fa-spin");
	
	$.ajax({
		url: "guardar_clientes.php",
		method: "POST",
		dataType: "JSON",
		data: $("#form_clientes").serialize()
		
		}).done(function(respuesta){
		console.log("respuesta",respuesta);
		if(respuesta.status == "success"){
			alertify.success(respuesta.mensaje);
			$("#modal_clientes").modal("hide");
			$("#form_filtros").submit();
		}
		}).fail(function(xht, error, errnum){
		
		alertify.error("Error", errnum);
		}).always(function(){
		boton.prop("disabled", false);
		icono.toggleClass("fa-save fa-spinner fa-spin");
		
	});
	
}	