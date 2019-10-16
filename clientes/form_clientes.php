<form id="form_clientes" autocomplete="off" class="is-validated">
	<div id="modal_clientes" class="modal fade" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title text-center">
						Editar Cliente
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</h3>
				</div>
				<div class="modal-body">
					<input type="text" hidden id="id_clientes" name="id_clientes">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="">Nombre:</label>
								<input  type="text" class="form-control" name="nombre" id="nombre" required>
							</div>
							<div class="form-group">
								<label for="">Teléfono:</label>
								<input  class="form-control" type="tel" name="telefono" id="telefono">
							</div>
							<div class="form-group">
								<label for="">Correo:</label>
								<input  class="form-control" type="email" name="correo" id="correo">
							</div>
							<div class="form-group">
								<label for="">Dirección:</label>
								<input  required class="form-control" type="text" name="direccion" id="direccion">
							</div>
							<div class="form-group">
								<label for="">Vendedor:</label>
								<?php echo generar_select($link,"vendedores","id_vendedores","nombre_vendedores"); ?>
							</div>
							<div class="form-group"> 
								<label for="activo">Estatus:</label>
								<select class="form-control" name="activo" id="activo">
									<option value="1">ACTIVO</option>
									<option value="0">INACTIVO</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
					<button type="submit" class="btn btn-success" id="btn_formAlta">
						<i class="fa fa-save"></i> Guardar
					</button>
				</div>
			</div>
		</div>
	</div>
</form>	