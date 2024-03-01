<?php
require_once "../config/conexion.php";

// Procesar el formulario de agregar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nombre_producto']) && !empty($_POST['precio']) && !empty($_POST['stock']) && !empty($_POST['proveedor'])) {
        $nombre_producto = $_POST['nombre_producto'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $proveedor = $_POST['proveedor'];
        
        $query = mysqli_query($conexion, "INSERT INTO productos (nombre_producto, precio, stock, proveedor) VALUES ('$nombre_producto', '$precio', '$stock', '$proveedor')");
        
        if ($query) {
            header('Location: productos.php');
            exit;
        } else {
            echo "Error al agregar el producto: " . mysqli_error($conexion);
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}

// Procesar el formulario de eliminar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    if (!empty($_POST['id'])) {
        $id_producto = $_POST['id'];
        
        $query_delete = mysqli_query($conexion, "DELETE FROM productos WHERE id_producto = $id_producto");
        
        if ($query_delete) {
            header('Location: productos.php');
            exit;
        } else {
            echo "Error al eliminar el producto: " . mysqli_error($conexion);
        }
    } else {
        echo "Por favor, seleccione un producto para eliminar.";
    }
}

include("includes/header.php");
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Productos</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirProducto"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Proveedor</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM productos ORDER BY id_producto DESC");
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['id_producto']; ?></td>
                            <td><?php echo $data['nombre_producto']; ?></td>
                            <td><?php echo $data['precio']; ?></td>
                            <td><?php echo $data['stock']; ?></td>
                            <td><?php echo $data['proveedor']; ?></td>
                            <td>
                                <form method="post" action="productos.php" class="d-inline eliminar">
                                    <input type="hidden" name="id" value="<?php echo $data['id_producto']; ?>">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#editarProducto<?php echo $data['id_producto']; ?>">Editar</button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="editarProducto<?php echo $data['id_producto']; ?>" tabindex="-1" role="dialog" aria-labelledby="editarProductoLabel<?php echo $data['id_producto']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarProductoLabel<?php echo $data['id_producto']; ?>">Editar Producto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="editar_producto.php" method="POST" autocomplete="off">
                                            <input type="hidden" name="id_producto" value="<?php echo $data['id_producto']; ?>">
                                            <div class="form-group">
                                                <label for="nombre_producto">Nombre</label>
                                                <input id="nombre_producto" class="form-control" type="text" name="nombre_producto" value="<?php echo $data['nombre_producto']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="precio">Precio</label>
                                                <input id="precio" class="form-control" type="text" name="precio" value="<?php echo $data['precio']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="stock">Stock</label>
                                                <input id="stock" class="form-control" type="text" name="stock" value="<?php echo $data['stock']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="proveedor">Proveedor</label>
                                                <input id="proveedor" class="form-control" type="text" name="proveedor" value="<?php echo $data['proveedor']; ?>" required>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="productos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Nuevo Producto</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="productos.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_producto">Nombre</label>
                                <input id="nombre_producto" class="form-control" type="text" name="nombre_producto" placeholder="Nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input id="stock" class="form-control" type="text" name="stock" placeholder="Stock" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proveedor">Proveedor</label>
                                <input id="proveedor" class="form-control" type="text" name="proveedor" placeholder="Proveedor" required>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>


