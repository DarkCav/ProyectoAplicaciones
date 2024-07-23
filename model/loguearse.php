<?php
/*include '../config/conexion.php';

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
                header("Location: ../view/admin_menu.html");
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
                window.location = '../view/registro_login.php';
              </script>";
    }
}
mysqli_close($conn)*/

include '../config/conexion.php';
session_start();

header('Content-Type: application/json');

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
            $_SESSION['user_id'] = $row['id_usuario'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_type'] = $row['tipo'];

            // Responder con éxito y la URL de redirección
            echo json_encode([
                'success' => true,
                'redirect' => $row['tipo'] === 'Administrador' ? '../view/admin_menu.html' : '../index.html'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Contraseña incorrecta',
                'clearFields' => 'password'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Usuario no encontrado',
            'clearFields' => 'both'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Método de solicitud inválido'
    ]);
}

mysqli_close($conn);

?>