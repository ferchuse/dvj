<?php
	
	include("../conexi.php");
	$link = Conectarse();
	
	$consulta = "
	SELECT
	id_ventas AS  id_transaccion,
	'CARGO' AS tipo,
	fecha_ventas AS fecha,
	CONCAT('VENTA #',id_ventas) AS concepto,
	total_ventas AS importe
	FROM
	ventas
	WHERE 
	id_clientes = '{$_GET["id_clientes"]}'
	AND	estatus_ventas <> 'CANCELADO'
	
	UNION
	
	SELECT
	id_abonos AS id_transaccion,
	'ABONO' as tipo,
	fecha,
	concepto,
	importe
	FROM
	abonos
	WHERE id_clientes = '{$_GET["id_clientes"]}'
	
	ORDER BY
	fecha
	";
	
	
	$result = mysqli_query($link,$consulta) or die ("<pre>Error en $consulta". mysqli_error($link). "</pre>");
	
	while($fila = mysqli_fetch_assoc($result)){
		
		$lista_transacciones[] = $fila;
		
	}
?>

<div id="modal_historial" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center">
					Estado de Cuenta
					
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					
				</h3>
			</div>
			<div class="modal-body">
				<a hidden data-toggle="collapse" data-target="#consulta">
					Mostrar SQL
				</a>
				
				<pre id="consulta" class="collapse">
					<?php echo $consulta;?>
				</pre>
				<div class="">
					
					<table class="table table-hover">
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Concepto</th>
							<th class="text-center">Cargo</th>
							<th class="text-center">Abono</th>
							<th class="text-center">Saldo</th>
							<th class="text-center">Acciones</th>
						</tr>
						<?php 
							$cargos= 0;
							$abonos= 0;
							$saldo= 0;
							foreach($lista_transacciones AS $i => $transaccion){
								
							?>
							<tr class="text-center">
								
								<td><?php echo date("d/m/Y", strtotime($transaccion["fecha"]));?></td>
								<td><?php echo $transaccion["concepto"];?></td>
								
								<?php if($transaccion["tipo"] == "CARGO"){
									$cargos+=$transaccion["importe"];
									$saldo+=$transaccion["importe"];
								?>
								<td>$<?php echo number_format($transaccion["importe"]);?></td>
								<td>-</td>
								
								<?php
								}
								else{
									$abonos+=$transaccion["importe"]; 
									$saldo-=$transaccion["importe"]; 
									
								?>
								
								<td>-</td>
								<td>$<?php echo number_format($transaccion["importe"]);?></td>
								
								<?php	
								}
								?>
								
								<td>$<?php echo number_format($saldo);?></td>
								<td>
									<button class="btn btn-danger btn_borrar_transaccion" 
									data-id_registro="<?php echo $transaccion["id_transaccion"]?>"
									data-tipo="<?php echo $transaccion["tipo"]?>"
									>
										<i class="fa fa-trash"></i>
									</button>
									
								</td>
								
							</tr>
							<?php
							}
						?>
						<tfoot class="h5 text-white bg-secondary text-center">
							<tr>
								<td>TOTALES:</td>
								<td></td>
								<td>$<?php echo number_format($cargos);?></td>
								<td>$<?php echo number_format($abonos);?></td>
								<td>$<?php echo number_format($saldo);?></td>
								
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times"></i> Cerrar
				</button>
			</div>
		</div>
	</div>
</div>
</form>	