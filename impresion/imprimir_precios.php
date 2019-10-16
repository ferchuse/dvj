<?php
include("../conexi.php");
$link = Conectarse();

$str_productos = implode(",", $_GET['id_productos']);
$consulta = "SELECT * FROM productos WHERE id_productos IN ({$str_productos})";

$result = mysqli_query($link, $consulta);
while ($fila = mysqli_fetch_assoc($result)) {
    $fila_productos[] = $fila;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tarjeta Precios "Nogui"</title>

    <!-- Bootstrap & CSS -->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/imprimir_precios.css">
</head>

<body>
    <div class="container">
        <!-- "Contenedor: Tarjetas" -->
        <div class="tarjetas row">

            <?php foreach ($fila_productos as $index => $producto) : ?>

                <!-- "Tarjeta: Precios" -->
                <div class="tarjeta col-6 h-full">
                    <div class="row justify-content-between h-full">
                        <!-- "Logo" -->
                        <div class="logo col-6 border-right-0 no-gutters">
                            <div class="row h-full align-items-center">
                                <div class="col-12">
                                    <img src="../img/logo.png">
                                </div>
                            </div>
                        </div>

                        <!-- "Datos: Etiqueta & Precios" -->
                        <div class="datos col-6 border-left-0 pr-4 pl-4 pt-2 pb-2">
                            <div class="row h-full align-items-center">
                                <!-- "Etiqueta: Producto" -->
                                <div class="etiqueta col-12 h-forty">
                                    <div class="row h-ninety align-items-center justify-content-center">
                                        <!-- "Producto" -->
                                        <div class="producto col-11 text-center">
                                            <?php echo $producto["descripcion_productos"]; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- "Precios: Producto" -->
                                <div class="precios col-12 h-sixty">
                                    <div class="row h-full align-items-middle">
                                        <!-- "Precio: Uno" -->
                                        <div class="col-12 h-auto">
                                            <div class="row h-full align-items-center">
                                                <!-- "Cantidad" -->
                                                <div class="cantidad col-7 h-auto ">
                                                    <div class="row h-full align-items-center">
                                                        <div class="col-12 text-bold">MENUDEO</div>
                                                    </div>
                                                </div>
                                                <!-- "Precio" -->
                                                <div class="precio col-5 h-auto">
                                                    <div class="row h-full align-items-center">
                                                        <div class="col-12">
                                                            <?php echo "$" . $producto["precio_menudeo"]; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- "Precio: Dos" -->
                                        <div class="col-12 h-auto">
                                            <div class="row h-full align-items-center">
                                                <!-- "Cantidad" -->
                                                <div class="cantidad col-7 h-auto ">
                                                    <div class="row h-full align-items-center">
                                                        <div class="col-12 text-bold">MÉDICO</div>
                                                    </div>
                                                </div>
                                                <!-- "Precio" -->
                                                <div class="precio col-5 h-auto">
                                                    <div class="row h-full align-items-center">
                                                        <div class="col-12">
                                                            <?php echo "$" . $producto["precio_medico"]; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>

        </div>
    </div>
</body>

</html>