<?php
require_once "../config/conexion.php";

$id_tienda = $_POST['id_tienda'];
$nombre_tienda = $_POST['nombre_tienda'];
$ciudad = $_POST['ciudad'];
$telefono = $_POST['telefono'];
$categoria = $_POST['categoria'];

$query_edit = mysqli_query($conexion, "UPDATE tiendas SET nombre_tienda = '$nombre_tienda', ciudad = '$ciudad', telefono = '$telefono', categoria = '$categoria' WHERE id_tienda = '$id_tienda'");

if ($query_edit) {
    header('Location: tiendas.php');
    exit;
} else {
    echo "Error al editar la tienda: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>

