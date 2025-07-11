<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Controller/LoginController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php PrintCss(); ?>

<body class="about-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.webp" alt=""> -->
        <svg class="my-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g id="bgCarrier" stroke-width="0"></g>
          <g id="tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="iconCarrier">
            <path d="M22 22L2 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M17 22V6C17 4.11438 17 3.17157 16.4142 2.58579C15.8284 2 14.8856 2 13 2H11C9.11438 2 8.17157 2 7.58579 2.58579C7 3.17157 7 4.11438 7 6V22" stroke="currentColor" stroke-width="1.5"></path>
            <path opacity="0.5" d="M21 22V8.5C21 7.09554 21 6.39331 20.6629 5.88886C20.517 5.67048 20.3295 5.48298 20.1111 5.33706C19.6067 5 18.9045 5 17.5 5" stroke="currentColor" stroke-width="1.5"></path>
            <path opacity="0.5" d="M3 22V8.5C3 7.09554 3 6.39331 3.33706 5.88886C3.48298 5.67048 3.67048 5.48298 3.88886 5.33706C4.39331 5 5.09554 5 6.5 5" stroke="currentColor" stroke-width="1.5"></path>
            <path d="M12 22V19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M10 12H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M5.5 11H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M5.5 14H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M17 11H18.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M17 14H18.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M5.5 8H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M17 8H18.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M10 15H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M12 9V5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M14 7L10 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
          </g>
        </svg>

        <h1 class="sitename">MediTrust</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="../Login/home.php">Home</a></li>
          <li><a href="about.html" class="active">About</a></li>
          <li><a href="departments.html">Departments</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="doctors.html">Doctors</a></li>
          <li class="dropdown"><a href="#"><span>More Pages</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="department-details.html">Department Details</a></li>
              <li><a href="service-details.html">Service Details</a></li>
              <li><a href="appointment.html">Appointment</a></li>
              <li><a href="testimonials.html">Testimonials</a></li>
              <li><a href="faq.html">Frequently Asked Questions</a></li>
              <li><a href="gallery.html">Gallery</a></li>
              <li><a href="terms.html">Terms</a></li>
              <li><a href="privacy.html">Privacy</a></li>
              <li><a href="404.html">404</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="appointment.html">Appointment</a>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <div class="breadcrumbs">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bi bi-house"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#">Category</a></li>
            <li class="breadcrumb-item active current">About</li>
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