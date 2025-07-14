<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Controller/LoginController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php PrintCss(); ?>

<body class="about-page">

      <?php PrintBarra(); ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <div class="breadcrumbs">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../Login/home.php"><i class="bi bi-house"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="#">Categoría</a></li>
            <li class="breadcrumb-item active current">Acerca de Nosotros</li>
          </ol>
        </nav>
      </div>

      <div class="title-wrapper">
        <h1>About</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
      </div>
    </div><!-- End Page Title -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          <div class="col-lg-6">
            <div class="content">
              <h2>Committed to Excellence in Healthcare</h2>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
              </p>
              <p>
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum sed ut perspiciatis.
              </p>

              <div class="stats-container" data-aos="fade-up" data-aos-delay="200">
                <div class="row gy-4">
                  <div class="col-sm-6 col-lg-12 col-xl-6">
                    <div class="stat-item">
                      <div class="stat-number">
                        <span data-purecounter-start="0" data-purecounter-end="25" data-purecounter-duration="1" class="purecounter"></span>+
                      </div>
                      <div class="stat-label">Years of Experience</div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-12 col-xl-6">
                    <div class="stat-item">
                      <div class="stat-number">
                        <span data-purecounter-start="0" data-purecounter-end="50000" data-purecounter-duration="2" class="purecounter"></span>+
                      </div>
                      <div class="stat-label">Patients Treated</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="cta-buttons" data-aos="fade-up" data-aos-delay="300">
                <a href="#" class="btn-primary">Meet Our Doctors</a>
                <a href="#" class="btn-secondary">View Our Services</a>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="image-section" data-aos="fade-left" data-aos-delay="200">
              <div class="main-image">
                <img src="assets/img/health/consultation-3.webp" alt="Healthcare consultation" class="img-fluid">
              </div>
              <div class="image-grid">
                <div class="grid-item">
                  <img src="assets/img/health/facilities-2.webp" alt="Medical facility" class="img-fluid">
                </div>
                <div class="grid-item">
                  <img src="assets/img/health/staff-5.webp" alt="Medical staff" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="certifications-section" data-aos="fade-up" data-aos-delay="400">
          <div class="row">
            <div class="col-lg-12">
              <div class="section-header">
                <h3>Accreditations &amp; Certifications</h3>
                <p>We are proud to be accredited by leading healthcare organizations</p>
              </div>
              <div class="certifications-grid">
                <div class="certification-item">
                  <img src="assets/img/clients/clients-1.webp" alt="JCI Accreditation" class="img-fluid">
                </div>
                <div class="certification-item">
                  <img src="assets/img/clients/clients-2.webp" alt="NABH Certification" class="img-fluid">
                </div>
                <div class="certification-item">
                  <img src="assets/img/clients/clients-3.webp" alt="ISO 9001" class="img-fluid">
                </div>
                <div class="certification-item">
                  <img src="assets/img/clients/clients-4.webp" alt="CAP Accreditation" class="img-fluid">
                </div>
                <div class="certification-item">
                  <img src="assets/img/clients/clients-5.webp" alt="Medical Board" class="img-fluid">
                </div>
                <div class="certification-item">
                  <img src="assets/img/clients/clients-6.webp" alt="Healthcare Association" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

  </main>

<?php PrintFooter(); ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

<?php PrintScript(); ?>

</body>

</html>