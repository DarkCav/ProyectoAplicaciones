<?php

session_start();
if (!isset($_SESSION['user_name'])) { //VALIDAR SESSION
    $_SESSION['msg'] = "NO SESSION";
    echo "<script>console.log('Debug Objects: " . $_SESSION['msg']  . "' );</script>";
    header('location: Controller/Controlador.php?opcion=1');
}

if (isset($_GET['logout'])) { //CERRAR SESSION
    echo "<script>console.log('Destroy session');</script>";
    //sleep(3);
    session_destroy();
    unset($_SESSION['user_name']);
    header("location: Controller/Controlador.php?opcion=1");
}

echo "<script>console.log('USER LOGGING: " . $_SESSION['user_name'] . "' );</script>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cárnicos - Sobre nosotros</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/carritomodal.css">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>Carabobo 14-31 y Boyaca, Riobamba, Ecuador, 060150</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>carnisanpedro@yahoo.es</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Síguenos:</small>
                <a class="text-body ms-3" href="https://www.facebook.com/CarnicosSanPedro/?locale=es_LA"><i class="fab fa-facebook-f"></i></a>
                <a class="text-body ms-3" href="https://www.tiktok.com/@carnicossanpedro.2"><i class="fab fa-twitter"></i></a>
                <a class="text-body ms-3" href="https://www.instagram.com/sanpedrocarniceriaoficial/"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold text-primary m-0">San<span class="text-secondary">Pe</span>dro</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="indexU.php" class="nav-item nav-link">Inicio</a>
                    <a href="about.php" class="nav-item nav-link active">Sobre nosotros</a>
                    <a href="productG.php" class="nav-item nav-link">Productos</a>
                    <a href="contact.php" class="nav-item nav-link">Contáctanos</a>
                </div>
                <div class="d-none d-lg-flex ms-2">
                    <div class="nav-item dropdown">
                        <a class="btn-sm-square bg-white rounded-circle ms-3" href="">
                            <small class="fa fa-user text-body"></small><?php echo $_SESSION['user_name']; ?>
                        </a>
                        <div class="dropdown-menu m-0">
                            <a href="Controller/Controlador.php?opcion=2" class="dropdown-item">Mis datos</a>
                            <a href="indexU.php?logout='1'" class="dropdown-item">Cerrar Sesión</a>
                        </div>
                    </div>
                    <!-- Botón del carrito -->
                    <a class="btn-sm-square bg-white rounded-circle ms-3" id="cart-button" href="#">
                        <small class="fa fa-shopping-bag text-body"></small>
                        <span id="cart-count" class="badge bg-primary rounded-circle">0</span>
                    </a>

                    <!-- Modal del carrito -->
                    <div id="cart-modal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Carrito de Compras</h2>
                            <div id="cart-list"></div>
                            <div id="cart-subtotal"></div>
                            <button id="view-cart-button" class="btn btn-primary">Ver carrito</button>
                            <button id="checkout-button" class="btn btn-success">Finalizar compra</button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Sobre nosotros</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="index.html">Inicio</a></li>
                    <!--<li class="breadcrumb-item"><a class="text-body" href="#">Páginas</a></li>-->
                    <li class="breadcrumb-item text-dark active" aria-current="page">Sobre nosotros</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img class="img-fluid w-100" src="img/about.jpg">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-5 mb-4">Las mejores carnes y con alta calidad</h1>
                    <p class="mb-4">El Local San Pedro es una carnicería de confianza que ofrece una amplia variedad de cortes de carne de alta calidad. Ubicado en el corazón del vecindario, el local se especializa en carnes frescas y productos selectos, atendiendo a sus clientes con un servicio amable y personalizado. Con un enfoque en la frescura y la calidad, el Local Pedro se ha convertido en un favorito entre los amantes de la buena carne, proporcionando opciones ideales para cualquier ocasión culinaria.</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Ofrece: Carne de res, Pollo, Carne de chando y embutidos</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Excelente atención al cliente</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Siempre con una buena higiene y seguridad alimentaria</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5 mt-3" href="">Leer más</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Firm Visit Start -->
    <div class="container-fluid bg-primary bg-icon mt-5 py-6">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-7 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-5 text-white mb-3">Visítanos</h1>
                    <p class="text-white mb-0">Te invitamos a descubrir el Local San Pedro, tu destino de confianza para cortes de carne de la más alta calidad. Ofrecemos una experiencia de compra única con una amplia selección de productos frescos y un servicio al cliente excepcional. 
                        Ven a conocer nuestro equipo amable y experto, quien estará encantado de ayudarte a elegir los mejores cortes para cada ocasión. Disfruta de un ambiente acogedor y aprovecha nuestras ofertas especiales mientras exploras nuestra variedad de carnes y productos gourmet. 
                        ¡Te esperamos con los brazos abiertos!</p>
                </div>
                <div class="col-md-5 text-md-end wow fadeIn" data-wow-delay="0.5s">
                    <a class="btn btn-lg btn-secondary rounded-pill py-3 px-5" href="">¡Visítanos ya!</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Firm Visit End -->


    <!-- Feature Start -->
    <div class="container-fluid bg-light bg-icon py-6">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3">Nuestras Características</h1>
                <p>Conoce las características que más nos definen:</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <img class="img-fluid mb-4" src="img/iconcarneres.png" alt="" style=" width: 80px; height:80px ;">
                        <h4 class="mb-3">Frescura inigualable</h4>
                        <p class="mb-4">Se garantiza que todos sus cortes de carne se mantengan frescos gracias a prácticas rigurosas de almacenamiento y manejo. Esto asegura que los clientes disfruten de productos que conservan su sabor y calidad.</p>
                        <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="">Leer más</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <img class="img-fluid mb-4" src="img/iconservivcio.png" alt="" style=" width: 80px; height:80px ;">
                        <h4 class="mb-3">Asesoramiento experto</h4>
                        <p class="mb-4">El personal está altamente capacitado para ofrecer recomendaciones y asesoramiento sobre los mejores cortes para cada tipo de preparación. Esto ayuda a los clientes a tomar decisiones informadas y a lograr resultados culinarios excepcionales.</p>
                        <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="">Leer más</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <img class="img-fluid mb-4" src="img/iconvarios.png" alt="" style=" width: 200px; height:80px ;">
                        <h4 class="mb-3">Variedad de productos</h4>
                        <p class="mb-4">Además de una amplia selección de cortes de carne, el Local ofrece productos adicionales como embutidos, carnes marinadas y preparados especiales. Esta variedad permite a los clientes encontrar todo lo que necesitan para sus comidas en un solo lugar.</p>
                        <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="">Leer más</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h1 class="fw-bold text-primary mb-4">San<span class="text-secondary">Pe</span>dro</h1>
                    <p>Si solicita atención, por favor contactar a la siguiente información de contacto</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href="https://www.instagram.com/carnicossanpedro/?hl=es"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href="https://www.facebook.com/CarnicosSanPedro/photos?locale=es_LA"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href="https://www.youtube.com/watch?v=K-9nDaonxDs"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Dirección</h4>
                    <p><i class="fa fa-map-marker-alt me-3"></i>Carabobo 14-31 y Boyaca, Riobamba, Ecuador, 060150</p>
                    <p><i class="fa fa-phone-alt me-3"></i>(03) 239-3548</p>
                    <p><i class="fa fa-envelope me-3"></i>carnisanpedro@yahoo.es</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Enlaces rápidos</h4>
                    <a class="btn btn-link" href="about.html">Sobre nosotros</a>
                    <a class="btn btn-link" href="contact.html">Contáctanos</a>
                    <a class="btn btn-link" href="">Nuestros servicios</a>
                    <a class="btn btn-link" href="">Términos & condiciones</a>
                    <a class="btn btn-link" href="">Soporte</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Boletín informativo</h4>
                    <p>Envíanos tu correo para notificarte promociones</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="su correo">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Inscribirse</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a href="#">Cárnicos San Pedro</a>, Derechos Reservados.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Diseñado por <a href="https://htmlcodex.com">Grupo 5</a>
                        <br>Distribuido por <a href="https://themewagon.com" target="_blank">ESPOCH</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/carrito.js"></script> 
</body>

</html>