<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Eliminar Cliente</title>

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <style>
        .nav-link {
            font-size: 1.5rem;
            position: relative;
        }

        .nav-link:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .footer-logo {
            font-size: 3rem;
        }

        .footer-container {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .btn-lg-square {
            display: none;
        }

        .trash-icon {
            cursor: pointer;
            color: red;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="#" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold text-primary m-0">San<span class="text-secondary">Pe</span>dro</h1>
            </a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="../view/admin_menu.html" class="nav-item nav-link">
                        <i class="bi bi-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Admin Menu Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3">Eliminar Cliente</h1>
                <p>Bienvenido, admin. Elimina clientes del sistema.</p>
            </div>
            <table class="table table-striped wow fadeInUp" data-wow-delay="0.1s">
                <thead>
                    <tr>
                        <th>ID del Cliente</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("../config/conexion.php");

                    $sql = "SELECT id_cliente, nombre, correo_electronico FROM cliente";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["id_cliente"] . "</td>";
                            echo "<td>" . $row["nombre"] . "</td>";
                            echo "<td>" . $row["correo_electronico"] . "</td>";
                            echo "<td><i class='bi bi-trash trash-icon' onclick='deleteClient(" . $row["id_cliente"] . ")'></i></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay clientes disponibles</td></tr>";
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Admin Menu End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer footer-container wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center">
            <h1 class="fw-bold text-primary mb-4 footer-logo">San<span class="text-secondary">Pe</span>dro</h1>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

    <script>
        function deleteClient(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este cliente?")) {
                $.ajax({
                    url: '../model/admin_delete_cli.php',
                    type: 'POST',
                    data: { id_cliente: id },
                    success: function(response) {
                        if (response == "success") {
                            alert("Cliente eliminado exitosamente.");
                            location.reload();
                        } else {
                            alert("Error al eliminar el cliente.");
                        }
                    }
                });
            }
        }
    </script>
</body>

</html>
