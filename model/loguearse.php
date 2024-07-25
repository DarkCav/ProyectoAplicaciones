<?php
header('Content-Type: text/html; charset=utf-8');
include '../config/conexion.php';
session_start();
// Asegurarse de que la conexión use UTF-8
mysqli_set_charset($conn, "utf8mb4");
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Preparar la consulta
    $query = "SELECT u.id_usuario, u.nombre, u.contraseña, u.tipo 
              FROM rol_usuario u 
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

/*session_start();
header('Content-Type: text/html; charset=utf-8');
include '../config/conexion.php';
mysqli_set_charset($conn, "utf8mb4");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT u.id_usuario, u.nombre, u.contraseña, u.tipo 
              FROM rol_usuario u 
              INNER JOIN cliente c ON u.id_usuario = c.id_usuario 
              WHERE c.correo_electronico = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultado)) {
        if (password_verify($contrasena, $row['contraseña'])) {
            $_SESSION['user_id'] = $row['id_usuario'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_type'] = $row['tipo'];

            // Código de depuración
            error_log("Sesión iniciada: " . print_r($_SESSION, true));

            echo json_encode([
                'success' => true,
                'redirect' => $row['tipo'] === 'Administrador' ? '../view/admin_menu.html' : '../indexU.php',
                'user_type' => $row['tipo']
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

mysqli_close($conn);*/

?>