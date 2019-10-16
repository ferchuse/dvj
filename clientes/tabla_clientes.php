<?php
include("../login/login_success.php");
include("../conexi.php");
include("../funciones/generar_select.php");
$link = Conectarse();
$menu_activo = "clientes";
$where = " where 1 ";

if (isset($_GET["sort"])) {
	$sort = $_GET["sort"];
	$order = $_GET["order"];
} else {
	$sort = "nombre";
	$order = "ASC";
}

if (isset($_GET["estatus_clientes"]) and $_GET["estatus_clientes"] != "todos") {
	$where .= " and activo = {$_GET['estatus_clientes']}";
};

if ($_GET["id_vendedores"] != "") {
	$where .= " and id_vendedores = '{$_GET['id_vendedores']}'";
};

$consulta = "
	SELECT
	id_clientes,
	nombre,
	nombre_vendedores,
	correo,
	telefono,
	activo,
	COALESCE ( suma_cargos, 0 ) - COALESCE ( suma_abonos, 0 ) AS saldo 
	FROM
	clientes
	LEFT JOIN vendedores USING(id_vendedores)
	LEFT JOIN ( 
	SELECT id_clientes, SUM( total_ventas ) AS suma_cargos
	FROM ventas WHERE estatus_ventas <> 'CANCELADO' 
	GROUP BY id_clientes 
	) AS t_cargos
	USING ( id_clientes )
	
	LEFT JOIN ( SELECT id_clientes, SUM( importe ) AS suma_abonos FROM abonos GROUP BY id_clientes ) AS t_abonos USING ( id_clientes )
	$where ORDER BY
	$sort $order 
	";

$result = mysqli_query($link, $consulta) or die("<pre>Error en $consulta" . mysqli_error($link) . "</pre>");

while ($fila = mysqli_fetch_assoc($result)) {
	$lista_clientes[] = $fila;
}
?>

<table id="tabla_clientes" class="table table-hover">
	<thead>
		<tr>
			<th class="text-center"><a class="sort" href="#!" data-columna="id_clientes">Id</a> </th>
			<th class="text-center"><a class="sort" href="#!" data-columna="nombre">Nombre</a> </th>
			<th class="text-center"><a class="sort" href="#!" data-columna="nombre_vendedores">Vendedor</a></th>
			<th class="text-center"><a class="sort" href="#!" data-columna="saldo">Saldo</a></th>
			<th class="text-center">Estatus</th>
			<th class="text-center">Acciones</th>
		</tr>
	</thead>

	<tbody>

		<?php foreach ($lista_clientes as $i => $cliente) { ?>

		<tr class="text-center">
			<td><?php echo $cliente["id_clientes"]; ?></td>
			<td><?php echo $cliente["nombre"]; ?></td>
			<td><?php echo $cliente["nombre_vendedores"]; ?></td>
			<td class="text-center">$<?php echo number_format($cliente["saldo"], 2); ?></td>
			<td class="text-center">
				<?php if ($cliente["activo"] == false) { ?>

				<button class="btn-red">
					Inactivo
				</button>

				<?php } else { ?>

				<button class="btn-green">
					Activo
				</button>

				<?php } ?>
			</td>
			<td>
				<a href="../ventas/ventas_nueva.php?id_clientes=<?php echo $cliente["id_clientes"] ?>&nombre=<?php echo $cliente["nombre"] ?>" class="btn btn-success ">
					+ <i class="fa fa-dollar-sign"></i> Cargo
				</a>
				<button class="btn btn-primary btn_abonos" data-id_registro="<?php echo $cliente["id_clientes"] ?>" data-saldo="<?php echo $cliente["saldo"] ?>">
					- <i class="fa fa-dollar-sign"></i> Abono
				</button>
				<button class="btn btn-info btn_historial" data-id_registro="<?php echo $cliente["id_clientes"] ?>">
					<i class="fa fa-history"></i> Historial
				</button>
				<button class="btn btn-warning btn_editar" data-id_registro="<?php echo $cliente["id_clientes"] ?>">
					<i class="fa fa-edit"></i> Editar
				</button>
			</td>
		</tr>

		<?php } ?>

	</tbody>
</table>
</div>