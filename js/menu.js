$(document).ready(function(){

	
	$( "#buscar_cliente" ).autocomplete({
		source: "control/search_json.php?tabla=cliente&campo=nombre_cliente&valor=nombre_cliente&etiqueta=nombre_cliente",
		minLength : 2,
		autoFocus: true,
		select: function( event, ui ) {
			//$(this).closest("form").submit();
			$("#id_buscar_cliente").val(ui.item.extras.id_cliente);
		//	$("#num_expediente").val(ui.item.extras.num_exp);
		//	console.log(ui.item.extras.id_paciente);
			
		}
	});	
	
	
	
});

