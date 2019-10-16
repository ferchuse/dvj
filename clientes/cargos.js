let btn_cargos = $('.btn_cargos');
let btn_abonos = $('.btn_abonos');
let form_cargos = $('#modal_cargos');

$(document).ready(function () {
	
	btn_cargos.click(function () {
		form_cargos.modal('show');
		$('#cargos_id_clientes').val($(this).data('id_registro'));
		$('#saldo_anterior').val($(this).data('saldo'));
		$('#tipo').val("cargos");
		$("#titulo").text("Cargo");
		
	});
	
	btn_abonos.click(function () {
		form_cargos.modal('show');
		$('#cargos_id_clientes').val($(this).data('id_registro'));
		$('#saldo_anterior').val($(this).data('saldo'));
		$('#tipo').val("abonos");
		$('#titulo').text("Abono");
		
	});
	
	$('#form_cargos').submit(guardarCargos)
	$('#importe').change(calcula_saldo)
	$('#importe').keyup(calcula_saldo)
	
	
})

function calcula_saldo(e) {
	let importe = Number($('#importe').val()); 
	let saldo_anterior = Number($('#saldo_anterior').val()); 
	let saldo_restante;
	console.log("tipo", $('#tipo').val()) ;
	
	if($('#tipo').val() == "cargos"){
		
		saldo_restante =  saldo_anterior + importe;
	}
	else{
		saldo_restante = saldo_anterior - importe;
	}
	
	$("#saldo_restante").val(saldo_restante);
}

function guardarCargos(event) {
	event.preventDefault();
	
	let boton = $(this).find(":submit");
	let icono = boton.find(".fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-save fa-spinner fa-spin");
	
	$.ajax({
		url: "guardar_cargos.php",
		method: "POST",
		dataType: "JSON",
		data: $("#form_cargos").serialize()
		
		}).done(function(respuesta){
		console.log("respuesta",respuesta);
		if(respuesta.status == "success"){
			
			alertify.success(respuesta.mensaje);
			$("#modal_cargos").modal("hide");
			window.location.reload(true);
		}
		}).fail(function(xht, error, errnum){
		
		alertify.error("Error", errnum);
		}).always(function(){
		boton.prop("disabled", false);
		icono.toggleClass("fa-save fa-spinner fa-spin");
		
	});
	
}
