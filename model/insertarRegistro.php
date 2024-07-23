<?php
/*include 'conexion_be.php';

$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];  

$query = "INSERT INTO usuarios (nombre_completo, correo, usuario, contrasena) VALUES ('$nombre_completo', '$correo', '$usuario', '$contrasena')";
$ejecutar = mysqli_query($conec, $query);

if ($ejecutar) {
    echo '
        <script>
            alert("Usuario almacenado exitosamente");
            window.location = "../index.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Intentelo de nuevo");
            window.location = "../index.php";
        </script>
    ';
}

mysqli_close($conec);*/
include '../config/conexion.php';

// Iniciar transacción
mysqli_begin_transaction($conec);

try {
    // Obtener datos del formulario
    $nombre = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);  // Hashear la contraseña
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $tipo_usuario = $_POST['tipo'];

    // Insertar en la tabla usuario
    $query_usuario = "INSERT INTO usuario (nombre, tipo, contraseña) VALUES (?, ?, ?)";
    $stmt_usuario = mysqli_prepare($conec, $query_usuario);
    mysqli_stmt_bind_param($stmt_usuario, "sss", $nombre, $tipo_usuario, $contrasena);
    mysqli_stmt_execute($stmt_usuario);

    // Obtener el id_usuario recién insertado
    $id_usuario = mysqli_insert_id($conec);

    // Insertar en la tabla cliente
    $query_cliente = "INSERT INTO cliente (nombre, direccion, telefono, correo_electronico, id_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt_cliente = mysqli_prepare($conec, $query_cliente);
    mysqli_stmt_bind_param($stmt_cliente, "ssssi", $nombre, $direccion, $telefono, $correo, $id_usuario);
    mysqli_stmt_execute($stmt_cliente);

    // Si todo está bien, confirmar la transacción
    mysqli_commit($conec);

    echo '
        <script>
            alert("Usuario registrado exitosamente");
            window.location = "../index.html";
        </script>
    ';
} catch (Exception $e) {
    // Si algo sale mal, revertir la transacción
    mysqli_rollback($conec);
    echo '
        <script>
            alert("Error al registrar el usuario: ' . $e->getMessage() . '");
            window.location = "../index.html";
        </script>
    ';
}

mysqli_close($conec);

?>