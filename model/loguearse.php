<?php
include '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Preparar la consulta
    $query = "SELECT u.id_usuario, u.nombre, u.contraseña, u.tipo 
              FROM usuario u 
              INNER JOIN cliente c ON u.id_usuario = c.id_usuario 
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
                window.location = '../view/registro_login.html';
              </script>";
    }
}
mysqli_close($conn);

/*// Activar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar el almacenamiento en búfer de salida
ob_start();

require_once '../config/conexion.php';

// Verificar la conexión antes de continuar
if (!check_connection($conn)) {
    die("La conexión a la base de datos se ha perdido.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Depuración: Imprimir los datos recibidos
    error_log("Correo recibido: " . $correo);

    // Preparar la consulta
    $query = "SELECT u.id_usuario, u.nombre, u.contraseña, u.tipo 
              FROM usuario u 
              INNER JOIN cliente c ON u.id_usuario = c.id_usuario 
              WHERE c.correo_electronico = ?";
    
    // Depuración: Imprimir la consulta
    error_log("Consulta SQL: " . $query);

    // Verificar la conexión justo antes de preparar la consulta
    if (!check_connection($conn)) {
        die("La conexión a la base de datos se perdió antes de preparar la consulta.");
    }

    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $correo);
    if (!mysqli_stmt_execute($stmt)) {
        die("Error al ejecutar la consulta: " . mysqli_stmt_error($stmt));
    }
    $resultado = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultado)) {
        // Verificar la contraseña
        if (password_verify($contrasena, $row['contraseña'])) {
            // Iniciar sesión
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_type'] = $row['tipo'];

            // Limpiar cualquier salida anterior
            ob_clean();

            // Depuración: Registrar el éxito del login
            error_log("Login exitoso para el usuario: " . $row['nombre']);

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
        // Depuración: Registrar el error
        error_log("Error de login: " . $error);

        echo "<script>
                alert('$error');
                window.location = '../view/registro_login.html';
              </script>";
        exit();
    }
} else {
    echo "No se recibieron datos POST.";
}

// Cerramos la conexión al final del script
mysqli_close($conn);

// Imprimir el búfer de salida y limpiarlo
ob_end_flush();*/
?>