<form id="form_edicion" autocomplete="off">
	<div class="modal fade" id="modal_edicion" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content"> 
				<div class="modal-header">
					
					<h4 class="modal-title">Vendedores</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group d-none">
							<label for="id_vendedores">ID</label>
							<input  readonly type="text" class="form-control" id="id_vendedores" name="id_vendedores" placeholder="">
						</div>
						<div class="form-group">
							<label for="nombre_vendedores">Nombre</label>
							<input required autofocus type="text" class="form-control" id="nombre_vendedores" name="nombre_vendedores" >
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input required type="password" class="form-control" id="password" name="password" >
						</div>
					</form> 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
				</div>
			</div>
		</div>
	</div>
</form>