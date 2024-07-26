<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    $_SESSION['msg'] = "NO SESSION";
    echo "<script>console.log('Debug Objects: " . $_SESSION['msg'] . "' );</script>";
    header('location: Controller/Controlador.php?opcion=1');
    exit();
}

if (isset($_GET['logout'])) {
    echo "<script>console.log('Destroy session');</script>";
    session_destroy();
    unset($_SESSION['user_name']);
    header("location: View/index.html");
    exit();
}

echo "<script>console.log('USER LOGGING: " . $_SESSION['user_name'] . "' );</script>";

include("config/conexion.php"); // Asegúrate de que la ruta sea correcta
include("config/producto.php");

$controlador = new Controlador($conn);

$tipoProductoId = isset($_GET['tipo']) ? intval($_GET['tipo']) : 8; // Por defecto mostrar Cerdo (id 8)
$productos = $controlador->obtenerProductosPorTipo($tipoProductoId);
$categoriaNombre = $controlador->obtenerNombreCategoria($tipoProductoId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>San Pedro - Productos</title>
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
                <small>Siguenos:</small>
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
                    <a href="about.php" class="nav-item nav-link">Sobre nosotros</a>
                    <a href="productG.php" class="nav-item nav-link active">Productos</a>
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
            <h1 class="display-3 mb-3 animated slideInDown">Productos San Pedro</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="index.html">Inicio</a></li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">Productos</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Product Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0 gx-5 align-items-end">
                <div class="col-lg-6">
                    <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                        <h1 class="display-5 mb-3">Nuestros Productos</h1>
                        <p>¡Bienvenido a nuestra variedad de carnes frescas y de alta calidad! Descubre una selección de pollo, cerdo, embutidos y más, perfectos para todas tus recetas.</p>
                    </div>
                </div>
                <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
                    <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary border-2 <?php echo $tipoProductoId == 8 ? 'active' : ''; ?>" href="productG.php?tipo=8">Cerdo</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary border-2 <?php echo $tipoProductoId == 11 ? 'active' : ''; ?>" href="productG.php?tipo=11">Res</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary border-2 <?php echo $tipoProductoId == 12 ? 'active' : ''; ?>" href="productG.php?tipo=12">Pollo</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary border-2 <?php echo $tipoProductoId == 9 ? 'active' : ''; ?>" href="productG.php?tipo=9">Embutidos</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <?php
                        if (empty($productos)) {
                            echo '<p>No hay productos disponibles en esta categoría.</p>';
                        } else {
                            foreach ($productos as $producto) {
                                $imagen = isset($producto['imagen_url']) ? $producto['imagen_url'] : 'uploads/default.jpg';
                                $precio = isset($producto['precio']) ? $producto['precio'] : '';
                                $id = isset($producto['id_producto']) ? $producto['id_producto'] : '';
                                $nombre = isset($producto['nombre']) ? $producto['nombre'] : '';
                                $descripcion = isset($producto['descripcion']) ? $producto['descripcion'] : '';
                                $peso = isset($producto['peso']) ? $producto['peso'] : '';
                                $stock = isset($producto['stock']) ? $producto['stock'] : '';

                                echo '
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="product-item">
                                        <div class="position-relative bg-light overflow-hidden">
                                            <img class="img-fluid w-100" src="'.$imagen.'" alt="'.$nombre.'">
                                            <div class="bg-secondary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">New</div>
                                        </div>
                                        <div class="text-center p-4">
                                            <a class="d-block h5 mb-2" href="#">'.$nombre.'</a>
                                            <span class="text-primary me-1">$'.$precio.'</span>
                                        </div>
                                        <div class="d-flex border-top">
                                            <small class="w-50 text-center border-end py-2">
                                                <a class="text-body" href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                                   data-name="'.$nombre.'"
                                                   data-description="'.$descripcion.'"
                                                   data-price="'.$precio.'"
                                                   data-weight="'.$peso.'"
                                                   data-category="'.$categoriaNombre.'"
                                                   data-stock="'.$stock.'"
                                                   data-image="'.$imagen.'"><i class="fa fa-eye text-primary me-2"></i>Ver detalles</a>
                                            </small>
                                            <small class="w-50 text-center py-2">
                                                <a class="text-body add-to-cart" data-id="'.$id.'" data-name="'.$nombre.'" data-price="'.$precio.'" href="#"><i class="fa fa-shopping-bag text-primary me-2"></i>Añadir al carrito</a>
                                            </small>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product End -->

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
                    <a class="btn btn-lg btn-secondary rounded-pill py-3 px-5" href="contact.html">¡Visítanos ya!</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Firm Visit End -->

    <!-- Testimonial Start -->
    <div class="container-fluid bg-light bg-icon py-6 mb-5">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3">Opiniones de los usuarios</h1>
                <p>Dentro de nuestras redes sociales hemos recibido las siguientes reseñas:</p>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">“Siempre encuentro los cortes más frescos y sabrosos en San Pedro. El personal es muy atento y me ayudan a elegir los mejores productos para mis cenas familiares. ¡Totalmente recomendado!”</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-1.jpg" alt="">
                        <div class="ms-3">
                            <h5 class="mb-1">Alison Bueno</h5>
                            <span>23 de febrero de 2020</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">“Excelente calidad y variedad en carnes. Me encanta que también ofrecen opciones de embutidos y marinados. El ambiente es amigable y el servicio rápido. Sin duda, mi carnicería de confianza.”</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-2.jpg" alt="">
                        <div class="ms-3">
                            <h5 class="mb-1">Fabricio Gonzáles</h5>
                            <span>12 de noviembre del 2019</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">“Visitar San Pedro es una experiencia muy agradable. Los precios son justos y el personal conoce bien su producto. Aprecio mucho la atención que me brindan y la calidad consistente de sus carnes.”</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-3.jpg" alt="">
                        <div class="ms-3">
                            <h5 class="mb-1">Marcelo Cuenca</h5>
                            <span>21 de octubre de 2019</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">“San Pedro es mi lugar favorito para comprar carne. La frescura de los productos es inigualable y siempre tienen lo que necesito. El trato personalizado hace que cada visita sea especial.”</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-4.jpg" alt="">
                        <div class="ms-3">
                            <h5 class="mb-1">Katia Ruíz</h5>
                            <span>22 de abril de 2020</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h1 class="fw-bold text-primary mb-4">Cár<span class="text-secondary">ni</span>cos</h1>
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

    <!-- Modal para ver detalles del producto -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Detalles del Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="modalProductImage" class="img-fluid" src="" alt="Producto">
                        </div>
                        <div class="col-md-6">
                            <h5 id="modalProductName"></h5>
                            <p id="modalProductDescription"></p>
                            <p><strong>Precio: </strong>$<span id="modalProductPrice"></span></p>
                            <p><strong>Peso: </strong><span id="modalProductWeight"></span> kg</p>
                            <p><strong>Categoría: </strong><span id="modalProductCategory"></span></p>
                            <p><strong>Stock: </strong><span id="modalProductStock"></span></p>
                            <button type="button" class="btn btn-primary add-to-cart" id="modalAddToCartButton">Añadir al carrito</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var productModal = document.getElementById('productModal');
        productModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var name = button.getAttribute('data-name');
            var description = button.getAttribute('data-description');
            var price = button.getAttribute('data-price');
            var weight = button.getAttribute('data-weight');
            var category = button.getAttribute('data-category');
            var stock = button.getAttribute('data-stock');
            var image = button.getAttribute('data-image');
            var id = button.getAttribute('data-id');

            var modalTitle = productModal.querySelector('.modal-title');
            var modalBodyName = productModal.querySelector('#modalProductName');
            var modalBodyDescription = productModal.querySelector('#modalProductDescription');
            var modalBodyPrice = productModal.querySelector('#modalProductPrice');
            var modalBodyWeight = productModal.querySelector('#modalProductWeight');
            var modalBodyCategory = productModal.querySelector('#modalProductCategory');
            var modalBodyStock = productModal.querySelector('#modalProductStock');
            var modalBodyImage = productModal.querySelector('#modalProductImage');
            var modalAddToCartButton = productModal.querySelector('#modalAddToCartButton');

            modalTitle.textContent = 'Detalles del Producto: ' + name;
            modalBodyName.textContent = name;
            modalBodyDescription.textContent = description;
            modalBodyPrice.textContent = price;
            modalBodyWeight.textContent = weight;
            modalBodyCategory.textContent = category;
            modalBodyStock.textContent = stock;
            modalBodyImage.src = image;

            modalAddToCartButton.setAttribute('data-id', id);
            modalAddToCartButton.setAttribute('data-name', name);
            modalAddToCartButton.setAttribute('data-price', price);
        });

        productModal.addEventListener('hidden.bs.modal', function (event) {
            var modalBodyImage = productModal.querySelector('#modalProductImage');
            modalBodyImage.src = '';
        });

        // Añadir el producto al carrito desde el modal
        document.getElementById('modalAddToCartButton').addEventListener('click', function(event) {
            addToCart(event);
        });
    </script>
</body>

</html>
