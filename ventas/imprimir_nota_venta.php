<?php
	
	include('../styles.php');
	include('../conexi.php');
	$link = Conectarse();
	$consulta = "SELECT * FROM ventas
	LEFT JOIN clientes USING (id_clientes)
	LEFT JOIN usuarios USING (id_usuarios)
	LEFT JOIN ventas_detalle USING (id_ventas)
	WHERE id_ventas={$_GET["id_ventas"]}";
	
	$result = mysqli_query($link, $consulta);
	
	while ($fila = mysqli_fetch_assoc($result)) {
    $fila_venta[] = $fila;
	}
	
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" media="all">
<link rel="stylesheet" href="../css/imprimir_nota_venta.css">
<div class="carta border-orange">
	<button class="btn btn-info d-print-none mt-3" onclick="window.print()">Imprimir</button>
	<div class="nota border-green">
		<div class="contenido border-purple">
			<!----- "Nota De Venta" ----->
			<div class="nota row w-full h-one no-gutters justify-content-end">
				<div class="w-one h-full border-grey"></div>
			</div>
			
			<!----- "Cliente, Vendedor & Fecha" ----->
			<div class="cliente row w-full h-one no-gutters justify-content-between margin-top">
				<div class="w-two h-full border-grey">
					<div class="row h-half w-full no-gutters">
						<div class="col-3 h-full pl-1"><span class="d-print-none">CLIENTE</span></div>
						<div class="col-9 h-full pl-1"><?php echo $fila_venta[0]["nombre"] ?></div>
					</div>
					<div class="row h-half w-full no-gutters">
						<div class="col-3 h-full pl-1"><span class="d-print-none">VENDEDOR</span></div>
						<div class="col-9 h-full pl-1"><?php echo $fila_venta[0]["nombre_usuarios"] ?></div>
					</div>
				</div>
				
				<div class="w-three h-full border-grey">
					<div class="row text-center h-full w-full no-gutters">
						<div class="w-full h-half"><span class="d-print-none">FECHA</span></div>
						<div class="w-full h-half">
							<div class="row h-full w-full no-gutters">
								<div class="col-4 h-full"><?php echo date("d", strtotime($fila_venta[0]["fecha_ventas"])); ?></div>
								<div class="col-4 h-full"><?php echo date("m", strtotime($fila_venta[0]["fecha_ventas"])); ?></div>
								<div class="col-4 h-full"><?php echo date("Y", strtotime($fila_venta[0]["fecha_ventas"])); ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!----- "Tabla Datos Del Producto: Encabezados" ----->
			<div class="encabezados row w-full h-four no-gutters margin-top text-center border-grey border-b-none">
				<div class="w-full h-full">
					<div class="row no-gutters w-full h-full">
						<div class="w-four h-full"><span class="d-print-none">CANTIDAD</span></div>
						<div class="w-five h-full"><span class="d-print-none">PRODUCTO</span></div>
						<div class="w-three h-full">
							<div class="row w-full h-full no-gutters">
								<div class="col-4 h-full"><span class="d-print-none">PRECIO</span></div>
								<div class="col-4 h-full"><span class="d-print-none">COSTO</span></div>
								<div class="col-4 h-full"><span class="d-print-none">IMPORTE</span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!----- "Tabla Datos Del Producto: Datos" ----->
			<div class="datos row w-full h-five no-gutters text-center border-grey border-t-none">
				
				<?php for ($i = 0; $i < 10; $i++) { ?>
					
					<div class="w-full h-tenth">
						<div class="row no-gutters w-full h-full">
							<div class="w-four h-full"><?php echo $fila_venta[$i]["cantidad"] ?></div>
							<div class="w-five h-full"><?php echo $fila_venta[$i]["descripcion"] ?></div>
							<div class="w-three h-full">
								<div class="row no-gutters w-full h-full">
									<div class="col-4 h-full"><?php echo $fila_venta[$i]["precio"] ?></div>
									<div class="col-4 h-full"></div>
									<div class="col-4 h-full"><?php echo $fila_venta[$i]["importe"] ?></div>
								</div>
							</div>
						</div>
					</div>
					
				<?php } ?>
				
			</div>
			
			<!----- "Observaciones, Pronto Pago, Total..." ----->
			<div class="observaciones row w-full h-three no-gutters text-center justify-content-between">
				<div class="w-two h-full">
					<div class="row w-full no-gutters h-six text-left border-grey border-none">
						<div class="w-full h-full ml-1"><span class="d-print-none">OBSERVACIONES</span></div>
					</div>
					<div class="row w-full no-gutters h-six text-left border-grey border-b-none">
						<div class="w-full h-full ml-1"></div>
					</div>
					<div class="row w-full no-gutters h-six text-left border-grey border-t-none">
						<div class="w-full h-full ml-1"></div>
					</div>
				</div>
				
				<div class="w-three h-full">
					<div class="row w-full h-full no-gutters">
						<div class="col-8 h-full">
							<div class="row no-gutters w-full h-six border-grey border-t-none border-b-none border-r-none">
								<div class="w-full h-full"><span class="d-print-none">SUBTOTAL</span></div>
							</div>
							<div class="row no-gutters w-full h-six border-grey border-t-none border-b-none border-r-none">
								<div class="w-full h-full"><span class="d-print-none">PRONTO PAGO</span></div>
							</div>
							<div class="row no-gutters w-full h-six border-grey border-t-none border-r-none">
								<div class="w-full h-full"><span class="d-print-none">TOTAL</span></div>
							</div>
						</div>
						
						<div class="col-4 h-full">
							<div class="row no-gutters w-full h-six border-grey border-t-none border-b-none border-l-none">
								<div class="w-full h-full"></div>
							</div>
							<div class="row no-gutters w-full h-six border-grey border-t-none border-b-none border-l-none">
								<div class="w-full h-full"></div>
							</div>
							<div class="row no-gutters w-full h-six border-grey border-t-none border-l-none">
								<div class="w-full h-full"><?php echo '$' . $fila_venta[0]["total_ventas"] ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>