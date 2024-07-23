<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Regístrarse</button>
                </div>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register" >
                <!--Login-->
                <form action="" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Correo Electronico">
                    <input type="password" placeholder="Contraseña">
                    <button>Entrar</button>
                </form>

                <!--Register-->
                <form action="../model/insertarRegistro.php" method="POST" class="formulario__register" id="registerForm">
                    <h2>Regístrarse</h2>
                    <input type="text" placeholder="Nombre completo" name="nombre_completo" required  pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+">
                    <input type="email" placeholder="Correo Electronico" name="correo" required>
                    <input type="text" placeholder="Contraseña" name="contrasena" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" required
                    title="La contraseña debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula, letras minúscula y al menos un número." >
                    <input type="text" placeholder="Dirección" name="direccion" required >
                    <input type="text" placeholder="Teléfono" name="telefono" required  pattern="\+593 \d{9}">
                    <select name="tipo" required>
                        <option value="">Seleccione el tipo de usuario</option>
                        <option value="administrador">Normal</option>
                        <option value="cliente">Administrador</option>
                    </select>
                    <button type="submit">Regístrarse</button>
                </form>
            </div>
        </div>
    </main>
    <script src="../js/registro.js"></script>
</body>
</html>