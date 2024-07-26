<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loguin y Registro</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/registro.css">
    <script>
        function showError(message) {
            alert(message);
        }

        function clearFields(fields) {
            if (fields === 'password' || fields === 'both') {
                document.querySelector('.formulario__login input[name="contrasena"]').value = '';
            }
            if (fields === 'both') {
                document.querySelector('.formulario__login input[name="correo"]').value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.formulario__login');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                
                fetch('../model/loguearse.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        showError(data.error);
                        clearFields(data.clearFields);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Ocurrió un error al procesar la solicitud.');
                });
            });
        });
    </script>
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
                <!--<form action="../model/loguearse.php" method="post" class="formulario__login">-->
                <form class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" name="correo" placeholder="Correo Electronico">
                    <input type="password" name="contrasena" placeholder="Contraseña">
                    <!--<button>Entrar</button>--><button type="submit">Entrar</button>
                </form>

                <!--Register-->
                <form action="../model/insertarRegistro.php" method="POST" class="formulario__register" id="registerForm">
                    <h2>Regístrarse</h2>
                    <input type="text" placeholder="Nombre y Apellido" name="nombre_completo" required  pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+">
                    <input type="email" placeholder="Correo Electronico" name="correo" required>
                    <input type="text" placeholder="Dirección" name="direccion" required >
                    <input type="text" placeholder="Teléfono" name="telefono" required  pattern="\d{10}">
                    <input type="password" placeholder="Contraseña" name="contrasena" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" required
                    title="La contraseña debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula, letras minúscula y al menos un número." >
                    <input type="password" placeholder="Confirmar contraseña" name="confirmar" id=" confirm_password">
                    <!--<select name="tipo" required>
                        <option value="">Seleccione el tipo de usuario</option>
                        <option value="Normal">Cliente</option>
                        <option value="Administrador">Administrador</option>
                    </select>-->
                    <button type="submit">Regístrarse</button>
                </form>
            </div>
        </div>
    </main>
    

    <script src="../js/registro.js"></script>
</body>
</html>