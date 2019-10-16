<?php
	
	include("../conexi.php");
	$link = Conectarse();
	
	$consulta = "
	
	SELECT
	id_clientes,
	id_vendedores,
	nombre,
	SUM(importe) AS total_abonado,
	fecha
	FROM
	clientes
	FULL JOIN abonos USING (id_clientes)
	WHERE
	id_vendedores = '{$_GET["id_vendedores"]}'
	AND fecha BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	GROUP BY id_clientes
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
				<a  data-toggle="collapse" data-target="#consulta">
					Mostrar SQL
				</a>
				
				<pre id="consulta" class="collapse">
					<?php echo $consulta;?>
				</pre>
				<div class="">
					
					<table class="table table-hover">
						<tr>
							<th class="text-center">Cliente</th>
							<th class="text-center">Abono</th>
							<th class="text-center">Comisión</th>
						</tr>
						<?php 
							$porc_comision = .05;
							$comision= 0;
							$abonos= 0;
							$saldo= 0;
							foreach($lista_transacciones AS $i => $transaccion){
								$abonos+=  $transaccion["total_abonado"];
								$comision+=  $transaccion["total_abonado"] * $porc_comision;
							?>
							<tr class="text-center">
								
								<td><?php echo $transaccion["nombre"];?></td>
								<td><?php echo $transaccion["total_abonado"];?></td>
								<td>$<?php echo number_format($transaccion["total_abonado"] * $porc_comision);?></td>
								
							</tr>
							<?php
							}
						?>
						<tfoot class="h4 text-white bg-primary text-center">
							<tr>
								<td>TOTALES:</td>
								<td>$<?php echo number_format($abonos);?></td>
								<td>$<?php echo number_format($comision);?></td>
								
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