<?php
include '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Preparar la consulta
    $query = "SELECT u.id, u.nombre, u.contraseña, u.tipo 
              FROM usuario u 
              INNER JOIN cliente c ON u.id = c.id_usuario 
              WHERE c.correo_electronico = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultado)) {
        // Verificar la contraseña
        if (password_verify($contrasena, $row['contraseña'])) {
            // Iniciar sesión
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_type'] = $row['tipo'];

            // Redirigir basado en el tipo de usuario
            if ($row['tipo'] === 'Administrador') {
                header("Location: ../admin_menu.html");
            } else {
                header("Location: ../index.html");
            }
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }

    if (isset($error)) {
        echo "<script>
                alert('$error');
                window.location = '../login.html';
              </script>";
    }
}

mysqli_close($conn);
?>