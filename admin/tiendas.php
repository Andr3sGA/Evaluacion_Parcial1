<?php
require_once "../config/conexion.php";

// Procesar el formulario de agregar tienda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nombre_tienda']) && !empty($_POST['ciudad']) && !empty($_POST['telefono']) && !empty($_POST['categoria'])) {
        $nombre_tienda = $_POST['nombre_tienda'];
        $ciudad = $_POST['ciudad'];
        $telefono = $_POST['telefono'];
        $categoria = $_POST['categoria'];
        
        $query = mysqli_query($conexion, "INSERT INTO tiendas (nombre_tienda, ciudad, telefono, categoria) VALUES ('$nombre_tienda', '$ciudad', '$telefono', '$categoria')");
        
        if ($query) {
            header('Location: tiendas.php');
            exit;
        } else {
            echo "Error al agregar la tienda: " . mysqli_error($conexion);
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}

// Procesar el formulario de eliminar tienda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    if (!empty($_POST['nombre_tienda'])) {
        $nombre_tienda = $_POST['nombre_tienda'];
        
        $query_delete = mysqli_query($conexion, "DELETE FROM tiendas WHERE nombre_tienda = '$nombre_tienda'");
        
        if ($query_delete) {
            header('Location: tiendas.php');
            exit;
        } else {
            echo "Error al eliminar la tienda: " . mysqli_error($conexion);
        }
    } else {
        echo "Por favor, seleccione una tienda para eliminar.";
    }
}

include("includes/header.php");
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tiendas</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirCategoria"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ciudad</th>
                        <th>Teléfono</th>
                        <th>Categoría</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM tiendas ORDER BY id_tienda DESC");
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['id_tienda']; ?></td>
                            <td><?php echo $data['nombre_tienda']; ?></td>
                            <td><?php echo $data['ciudad']; ?></td>
                            <td><?php echo $data['telefono']; ?></td>
                            <td><?php echo $data['categoria']; ?></td>
                            <td>
                                <form method="post" action="tiendas.php" class="d-inline eliminar">
                                    <input type="hidden" name="nombre_tienda" value="<?php echo $data['nombre_tienda']; ?>">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#editarTienda<?php echo $data['id_tienda']; ?>">Editar</button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="editarTienda<?php echo $data['id_tienda']; ?>" tabindex="-1" role="dialog" aria-labelledby="editarTiendaLabel<?php echo $data['id_tienda']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarTiendaLabel<?php echo $data['id_tienda']; ?>">Editar Tienda</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="editar_tienda.php" method="POST" autocomplete="off">
                                            <input type="hidden" name="id_tienda" value="<?php echo $data['id_tienda']; ?>">
                                            <div class="form-group">
                                                <label for="nombre_tienda">Nombre</label>
                                                <input id="nombre_tienda" class="form-control" type="text" name="nombre_tienda" value="<?php echo $data['nombre_tienda']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="ciudad">Ciudad</label>
                                                <input id="ciudad" class="form-control" type="text" name="ciudad" value="<?php echo $data['ciudad']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Teléfono</label>
                                                <input id="telefono" class="form-control" type="text" name="telefono" value="<?php echo $data['telefono']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="categoria">Categoría</label>
                                                <input id="categoria" class="form-control" type="text" name="categoria" value="<?php echo $data['categoria']; ?>" required>
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

<div id="categorias" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Nueva Tienda</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="tiendas.php" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="nombre_tienda">Nombre</label>
                        <input id="nombre_tienda" class="form-control" type="text" name="nombre_tienda" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input id="ciudad" class="form-control" type="text" name="ciudad" placeholder="Ciudad" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <input id="categoria" class="form-control" type="text" name="categoria" placeholder="Categoría" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

