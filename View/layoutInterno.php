<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function BarraNavegacion()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION["IdUsuario"])) {
        header('Location: login.php');
        exit;
    }

    $nombre = htmlspecialchars($_SESSION["NombreUsuario"] ?? 'Invitado', ENT_QUOTES);
    $perfil = (int) ($_SESSION["IdPerfil"] ?? 0);
    
    echo '
    <!-- Modal de Logout - Debe estar preferiblemente al final del body -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-gradient-custom-2 text-white">
            <h5 class="modal-title" id="logoutModalLabel">Confirmar cierre</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <span>¿Seguro que quieres cerrar sesión, '.$nombre.'?</span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a href="../Login/Logout.php" class="btn btn-danger">Sí, cerrar sesión</a>
          </div>
        </div>
      </div>
    </div>';

    echo '<nav class="navbar navbar-expand-lg navbar-dark nav-gradient">
    <div class="container-fluid">
        <a class="navbar-brand" href="../Login/home.php">
            <img src="../imgs/logo.png" width="50" height="50" class="me-2" alt="Logo">
            Salud Integral CR
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="../Login/home.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="../Productos/Catalogo.php">Catálogo</a></li>
                <li class="nav-item"><a class="nav-link" href="../Servicios/MostrarServicios.php">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="../Pedidos/ListaPedidos.php">Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="../Reseñas/CrearResena.php">Reseñas</a></li>';

    if ($perfil === 1) {
        echo '
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administración
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="../Productos/AdministrarProductos.php">Productos</a></li>
                        <li><a class="dropdown-item" href="../Proveedores/AdministrarProveedores.php">Proveedores</a></li>
                        <li><a class="dropdown-item" href="../Servicios/AdministrarServicios.php">Servicios</a></li>
                        <li><a class="dropdown-item" href="../Pedidos/AdministrarPedidos.php">Pedidos</a></li>
                        <li><a class="dropdown-item" href="../Reseñas/AdministrarResena.php">Reseñas</a></li>
                    </ul>
                </li>';
    }

    echo '
          </ul>
          <ul class="navbar-nav ms-auto me-3 d-flex align-items-center">
            <li class="nav-item d-flex align-items-center me-4">
              <i class="fas fa-user-circle fs-5 text-white"></i>
              <span class="ms-2 text-white fw-semibold">'.$nombre.'</span>
            </li>
            <li class="nav-item me-3">
              <a class="nav-link d-flex align-items-center" href="/Proyecto-LBD-Grupo-5/View/Usuario/cambiarContrasenna.php" title="Cambiar contraseña">
                <i class="fas fa-key me-1"></i>
                <span class="d-none d-lg-inline">Cambiar Contraseña</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" 
                href="#" 
                data-bs-toggle="modal" 
                data-bs-target="#logoutModal"
                title="Salir">
                <i class="fas fa-sign-out-alt me-1"></i>
                <span class="d-none d-lg-inline">Salir</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>';
}

function PrintCss()
{
    echo '<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Salud Integral CR</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

<!-- Favicons -->
<link href="../assets/img/favicon.png" rel="icon">
<link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- Fonts -->
 
<link href="https://fonts.googleapis.com" rel="preconnect">
<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="../assets/vendor/aos/aos.css" rel="stylesheet">
<link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

<!-- Main CSS File -->
<link href="../assets/css/main.css" rel="stylesheet">

</head>';
}


function PrintBarra() 
{
    echo '
  <header id="header" class="header d-flex align-items-center fixed-top mt-4">
    <div class="header-container container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="home.php" class="logo d-flex align-items-center me-auto">
        <img src="../assets/img/logo2.jpg" alt="Logo Salud Integral CR" width="40" class="me-2">
        <h1 class="sitename mb-0">Salud Integral CR</h1>
      </a>


    <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="../Login/home.php">Inicio</a></li>
          <li><a href="../Servicios/about.php">Acerca de Nosotros</a></li>
          <li><a href="departments.html">Departamentos</a></li>
          <li><a href="services.html">Servicios</a></li>
          <li><a href="doctors.html">Doctores</a></li>


          <li><a href="contact.html">Contacto</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="appointment.html">Agendar tu cita</a>

    </div>
      </header>

  <style>
    main.container {
      margin-top: 120px;
    }
  </style>
      
';
}


function PrintScript()
{
  echo '  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/js/main.js"></script>
';
}

function PrintFooter()
{
    echo '
    <footer id="footer" class="footer gradient-custom-2 text-white text-center text-lg-start mt-auto">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Salud Integral CR</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Hic solutasetp</h4>
          <ul>
            <li><a href="#">Molestiae accusamus iure</a></li>
            <li><a href="#">Excepturi dignissimos</a></li>
            <li><a href="#">Suscipit distinctio</a></li>
            <li><a href="#">Dilecta</a></li>
            <li><a href="#">Sit quas consectetur</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nobis illum</h4>
          <ul>
            <li><a href="#">Ipsam</a></li>
            <li><a href="#">Laudantium dolorum</a></li>
            <li><a href="#">Dinera</a></li>
            <li><a href="#">Trodelas</a></li>
            <li><a href="#">Flexo</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">MyWebsite</strong> <span>All Rights Reserved</span></p>
    </div>
    </footer>';
}
?>