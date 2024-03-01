<?php
require_once "../config/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id_producto']) && !empty($_POST['nombre_producto']) && !empty($_POST['precio']) && !empty($_POST['stock']) && !empty($_POST['proveedor'])) {
        $id_producto = $_POST['id_producto'];
        $nombre_producto = $_POST['nombre_producto'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $proveedor = $_POST['proveedor'];
        
        $query = mysqli_query($conexion, "UPDATE productos SET nombre_producto = '$nombre_producto', precio = '$precio', stock = '$stock', proveedor = '$proveedor' WHERE id_producto = $id_producto");
        
        if ($query) {
            header('Location: productos.php');
            exit;
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($conexion);
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
