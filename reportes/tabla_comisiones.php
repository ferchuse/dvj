<?php
	
	include("../conexi.php");
	$link = Conectarse();
	$total = 0;
	$registros= [];
	$total_comisiones = 0;
	
	$consulta = "SELECT
	id_vendedores, nombre_vendedores, abonado_vendedor
	FROM
	vendedores
	LEFT JOIN (
	SELECT
	id_vendedores,
	COALESCE(SUM(abonado_cliente), 0) AS abonado_vendedor
	FROM
	clientes
	LEFT JOIN (
	SELECT
	id_clientes,
	SUM(importe) AS abonado_cliente
	FROM
	abonos
	WHERE 
	DATE(fecha) BETWEEN '{$_POST['fecha_inicio']}'
	AND '{$_POST['fecha_fin']}'  
	GROUP BY
	id_clientes
	) AS abonado_cliente USING (id_clientes)
	GROUP BY
	id_vendedores
	) AS abonado_vendedor
	USING (id_vendedores)
	";
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
<pre hidden>
	<?php echo $consulta;?>
</pre>
<hr>
<?php if(count($registros) > 0){?>

	<table class="table table-striped table-hover" >
		<thead>
			<tr class="success">
				<th>Vendedor</th>
				<th>Total Cobrado</th>
				<th>Comisión</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
				
				foreach($registros AS $i=>$fila){	
					$total+=  $fila["abonado_vendedor"];
					$comision =  $fila["abonado_vendedor"] * .1;
					$total_comisiones+= $comision;
				?>
				<tr class="clickable" data-id_vendedores="<?php echo $fila["id_vendedores"];?>">
					<td><?php echo $fila["nombre_vendedores"] ?></td> 
					<td class="text-right"><?php echo $fila["abonado_vendedor"] ?></td> 
					<td class="text-right"><?php echo $comision ?></td> 
				</tr>
				<?php
				}
			?>
		</tbody>
		<tfoot class="bg-secondary text-white">
			<tr class="">
				<td  ><b>TOTALES</b></td> 
				<td class="text-right"><b>$<?php echo number_format($total) ?></b></td> 
				<td class="text-right"><b>$<?php echo number_format($total_comisiones)?></b></td> 
			</tr>
		</tfoot>
	</table>
	<?php
	}
	else{
		
		echo "<div class='alert alert-warning'>No hay Ventas en este periodo</div>";
	}
?>