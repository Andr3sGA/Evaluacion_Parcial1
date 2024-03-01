<?php
require_once "../config/conexion.php";

// Insertar una nueva venta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nombre_producto']) && !empty($_POST['nombre_tienda'])) {
        $nombre_producto = $_POST['nombre_producto'];
        $nombre_tienda = $_POST['nombre_tienda'];
        
        // Insertar los nombres en la tabla vende
        $query_insert = mysqli_query($conexion, "INSERT INTO vende (nombre_producto, nombre_tienda) VALUES ('$nombre_producto', '$nombre_tienda')");
        
        if ($query_insert) {
            header('Location: ventas.php');
            exit;
        } else {
            echo "Error al agregar la venta: " . mysqli_error($conexion);
        }
    }
}

// Eliminar una venta
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar' && isset($_GET['nombre_tienda']) && isset($_GET['nombre_producto'])) {
    $nombre_tienda = $_GET['nombre_tienda'];
    $nombre_producto = $_GET['nombre_producto'];
    
    $query_delete = mysqli_query($conexion, "DELETE FROM vende WHERE nombre_tienda = '$nombre_tienda' AND nombre_producto = '$nombre_producto'");
    
    if ($query_delete) {
        header('Location: ventas.php');
        exit;
    } else {
        echo "Error al eliminar la venta: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
</head>
<body>
    <?php include("includes/header.php"); ?>
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ventas</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirVenta" data-toggle="modal" data-target="#nuevaVenta"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width: 100%;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Tienda</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conexion, "SELECT * FROM vende");
                        if ($query) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>" . $row['nombre_producto'] . "</td>";
                                echo "<td>" . $row['nombre_tienda'] . "</td>";
                                echo "<td><a href='ventas.php?accion=eliminar&nombre_tienda=" . $row['nombre_tienda'] . "&nombre_producto=" . $row['nombre_producto'] . "' class='btn btn-danger'>Eliminar</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "Error al obtener las ventas: " . mysqli_error($conexion);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="nuevaVenta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="title">Nueva Venta</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="ventas.php" method="POST">
                        <div class="form-group">
                            <label for="nombre_producto">Nombre del Producto:</label>
                            <select id="nombre_producto" name="nombre_producto" required>
                                <?php
                                $query = mysqli_query($conexion, "SELECT nombre_producto FROM productos");
                                if ($query) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<option value='" . $row['nombre_producto'] . "'>" . $row['nombre_producto'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Error al obtener productos</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre_tienda">Nombre de la Tienda:</label>
                            <select id="nombre_tienda" name="nombre_tienda" required>
                                <?php
                                $query = mysqli_query($conexion, "SELECT nombre_tienda FROM tiendas");
                                if ($query) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<option value='" . $row['nombre_tienda'] . "'>" . $row['nombre_tienda'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Error al obtener tiendas</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Venta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
</body>
</html>






