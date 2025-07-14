<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Controller/LoginController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html>
<html lang="es">

<?php PrintCss(); ?>

<body class="index-page">

      <?php PrintBarra(); ?>
 
  <main>
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
      <div class="container-fluid p-0">
        <div class="hero-wrapper">
          <div class="hero-image">
            <img src="../assets/img/health/showcase-1.webp" alt="Advanced Healthcare" class="img-fluid">
          </div>
          <div class="hero-content">
            <div class="container">
              <div class="row">
                <div class="col-lg-7 col-md-10" data-aos="fade-right">
                  <span class="badge-accent mb-3">Liderando tu Salud</span>
                  <h1 class="display-5 text-white">Cuidado Médico Avanzado para tu Familia</h1>
                  <p class="text-light mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis.</p>
                  <div class="d-flex gap-2 mb-4">
                    <a href="appointment.php" class="btn btn-primary">Agenda tu Espacio</a>
                    <a href="services.php" class="btn btn-outline-light">Explora Nuestros Servicios</a>
                  </div>
                  <div class="d-flex gap-4">
                    <div class="d-flex align-items-center text-light">
                      <i class="bi bi-telephone-fill fs-3 me-2"></i>
                      <div>
                        <small>Línea de Emergencia</small><br>
                        <strong>+506 1273-6543</strong>
                      </div>
                    </div>
                    <div class="d-flex align-items-center text-light">
                      <i class="bi bi-clock-fill fs-3 me-2"></i>
                      <div>
                        <small>Horario de Atención</small><br>
                        <strong>Lun-Vie: 8AM-8PM</strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Dashboard Modules -->
    <section class="py-5">
      <div class="container">
        <div class="row g-4">
          <!-- Pacientes -->
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card text-center shadow-sm h-100">
              <div class="card-body d-flex flex-column">
                <i class="bi bi-people-fill fs-1 text-primary mb-3"></i>
                <h5 class="card-title">Pacientes</h5>
                <div class="mt-auto">
                  <a href="../Pacientes/list.php" class="btn btn-outline-primary mb-2 w-100">Ver lista</a>
                  <a href="../Pacientes/create.php" class="btn btn-primary w-100">Nuevo paciente</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Doctores -->
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card text-center shadow-sm h-100">
              <div class="card-body d-flex flex-column">
                <i class="bi bi-person-badge-fill fs-1 text-success mb-3"></i>
                <h5 class="card-title">Doctores</h5>
                <div class="mt-auto">
                  <a href="../Doctores/list.php" class="btn btn-outline-success mb-2 w-100">Ver lista</a>
                  <a href="../Doctores/create.php" class="btn btn-success w-100">Nuevo doctor</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Especialidades -->
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card text-center shadow-sm h-100">
              <div class="card-body d-flex flex-column">
                <i class="bi bi-journal-medical fs-1 text-warning mb-3"></i>
                <h5 class="card-title">Especialidades</h5>
                <div class="mt-auto">
                  <a href="../Especialidad/list.php" class="btn btn-outline-warning mb-2 w-100">Ver lista</a>
                  <a href="../Especialidad/create.php" class="btn btn-warning w-100">Nueva</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Consultas -->
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card text-center shadow-sm h-100">
              <div class="card-body d-flex flex-column">
                <i class="bi bi-calendar2-check-fill fs-1 text-info mb-3"></i>
                <h5 class="card-title">Consultas</h5>
                <div class="mt-auto">
                  <a href="../Cita/list.php" class="btn btn-outline-info mb-2 w-100">Ver agenda</a>
                  <a href="../Cita/create.php" class="btn btn-info w-100">Agendar</a>
                </div>
              </div>
            </div>
          </div>
        <!-- </div>
      </div> -->

          <div class="col-sm-6 col-md-4 col-lg-3">
  <div class="card text-center shadow-sm h-100">
    <div class="card-body d-flex flex-column">
      <i class="bi bi-cash-stack fs-1 text-danger mb-3"></i>
      <h5 class="card-title">Pagos</h5>
      <div class="mt-auto">
        <a href="../Pago/list.php"   class="btn btn-outline-danger mb-2 w-100">Ver lista</a>
        <a href="../Pago/create.php" class="btn btn-danger w-100">Nuevo pago</a>
      </div>
    </div>
  </div>
</div>

<!-- Usuarios -->
<div class="col-sm-6 col-md-4 col-lg-3">
  <div class="card text-center shadow-sm h-100">
    <div class="card-body d-flex flex-column">
      <i class="bi bi-person-lines-fill fs-1 text-secondary mb-3"></i>
      <h5 class="card-title">Usuarios</h5>
      <div class="mt-auto">
        <a href="../Usuario/list.php"   class="btn btn-outline-secondary mb-2 w-100">Ver lista</a>
        <a href="../Usuario/create.php" class="btn btn-secondary w-100">Nuevo usuario</a>
      </div>
    </div>
  </div>
</div>

<!-- Disponibilidad -->
<div class="col-sm-6 col-md-4 col-lg-3">
  <div class="card text-center shadow-sm h-100">
    <div class="card-body d-flex flex-column">
      <i class="bi bi-clock-history fs-1 text-primary mb-3"></i>
      <h5 class="card-title">Disponibilidad</h5>
      <div class="mt-auto">
        <a href="../Disponibilidad/list.php"   class="btn btn-outline-primary mb-2 w-100">Ver lista</a>
        <a href="../Disponibilidad/create.php" class="btn btn-primary w-100">Nueva</a>
      </div>
    </div>
  </div>
</div>

<!-- Historial Médico -->
<div class="col-sm-6 col-md-4 col-lg-3">
  <div class="card text-center shadow-sm h-100">
    <div class="card-body d-flex flex-column">
      <i class="bi bi-file-earmark-medical-fill fs-1 text-warning mb-3"></i>
      <h5 class="card-title">Historial</h5>
      <div class="mt-auto">
        <a href="../Historial/list.php"   class="btn btn-outline-warning mb-2 w-100">Ver lista</a>
        <a href="../Historial/create.php" class="btn btn-warning w-100">Nuevo registro</a>
      </div>
    </div>
  </div>
</div>
        </div>
      </div>
    </section>



    <!-- Quick Overview -->
    <section class="py-5 bg-light">
      <div class="container">
        <h3 class="mb-4">Próximas Consultas</h3>
        <table class="table table-hover mb-5">
          <thead class="table-secondary">
            <tr><th>Paciente</th><th>Doctor</th><th>Fecha</th><th>Hora</th></tr>
          </thead>
          <tbody>
            <tr><td>Juan Pérez</td><td>Dra. Méndez</td><td>10/Jun/2025</td><td>09:00</td></tr>
            <tr><td>Ana López</td><td>Dr. Ruiz</td><td>10/Jun/2025</td><td>10:30</td></tr>
          </tbody>
        </table>

        <h3 class="mb-4">Recordatorios</h3>
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Recordatorio: Control anual (12/Jun/2025)
            <a href="recordatorios/list.php" class="btn btn-sm btn-outline-secondary">Ver</a>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Recordatorio: Vacuna (15/Jun/2025)
            <a href="recordatorios/list.php" class="btn btn-sm btn-outline-secondary">Ver</a>
          </li>
        </ul>
      </div>
    </section>

  </main>

<?php PrintFooter(); ?>

  <a href="#" id="scroll-top" class="scroll-top"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

<?php PrintScript(); ?>

</body>
</html>
