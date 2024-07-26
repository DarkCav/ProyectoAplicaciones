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
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Crear el directorio si no existe
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Validar que el archivo es una imagen y que es un PNG
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check === false) {
        echo "El archivo no es una imagen.";
        exit;
    }

    if ($imageFileType != "png") {
        echo "Error: solo se permiten archivos PNG.";
        exit;
    }

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        // Obtener la URL relativa de la imagen
        $imagen_url = "uploads/" . basename($_FILES["imagen"]["name"]);

        // Insertar el producto en la base de datos
        $sql = "INSERT INTO producto (nombre, descripcion, precio, stock, id_tipo_producto, imagen_url, peso)
                VALUES ('$nombre', '$descripcion', '$precio', '$cantidad', '$id_tipo_producto', '$imagen_url', '$peso')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Producto subido exitosamente.');
                    window.location.href = '../view/admin_subir.html';
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error al subir la imagen.";
    }

    mysqli_close($conn);
}
?>
