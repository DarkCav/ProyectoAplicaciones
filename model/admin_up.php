<?php
include("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $peso = $_POST['peso'];
    $id_tipo_producto = $_POST['id_tipo_producto'];

    // Manejar la subida de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $imagen_nombre = $imagen['name'];
        $imagen_tmp = $imagen['tmp_name'];

        // Verificar el tipo de archivo
        $extensiones_permitidas = ['png'];
        $extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);

        if (in_array($extension, $extensiones_permitidas)) {
            // Definir la ruta donde se almacenará la imagen
            $imagen_url = '../uploads/' . $imagen_nombre;

            // Mover la imagen al directorio de destino
            if (move_uploaded_file($imagen_tmp, $imagen_url)) {
                // Insertar el producto en la base de datos
                $sql = "INSERT INTO producto (nombre, descripcion, precio, stock, id_tipo_producto, imagen_url)
                        VALUES ('$nombre', '$descripcion', '$precio', '$cantidad', '$id_tipo_producto', '$imagen_url')";

                if (mysqli_query($conn, $sql)) {
                    echo "<script>
                            alert('Producto subido exitosamente.');
                            window.location.href = '../view/admin_subir.html';
                          </script>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Error al mover la imagen.";
            }
        } else {
            echo "Error: Solo se permiten archivos PNG.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
}

mysqli_close($conn);
?>
