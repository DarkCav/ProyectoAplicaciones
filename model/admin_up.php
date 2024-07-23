<?php
include("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $peso = $_POST['peso'];

    // Manejar la subida de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $imagen_nombre = $imagen['name'];
        $imagen_tipo = $imagen['type'];
        $imagen_tmp = $imagen['tmp_name'];
        $imagen_tamano = $imagen['size'];

        // Verificar el tipo de archivo
        $extensiones_permitidas = ['png'];
        $extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);

        if (in_array($extension, $extensiones_permitidas)) {
            // Leer el contenido del archivo
            $imagen_contenido = addslashes(file_get_contents($imagen_tmp));

            // Insertar el producto en la base de datos
            $sql = "INSERT INTO producto (nombre, descripcion, precio, cantidad_disponible, peso_lb, imagen)
                    VALUES ('$nombre', '$descripcion', '$precio', '$cantidad', '$peso', '$imagen_contenido')";

            
        } else {
            echo "Error: Solo se permiten archivos PNG.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
}

$conec->close();
?>
