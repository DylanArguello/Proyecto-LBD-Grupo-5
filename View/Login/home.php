<?php
// View/home.php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Controller/LoginController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/CitaModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/RecordatorioModel.php";

$citaModel = new CitaModel();
$recordatorioModel = new RecordatorioModel();

/* ===== Helpers ===== */
function rows_from($maybe) {
  $out = [];
  if (is_object($maybe) && get_class($maybe) === 'OCIStatement') {
    while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
  } elseif (is_resource($maybe)) {
    while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
  } elseif (is_array($maybe)) { $out = $maybe; }
  return $out;
}
function toIsoDate(?string $v): string {
  $v = trim((string)$v);
  if ($v === '') return '';
  // soporta 'YYYY-MM-DD' y 'YYYY-MM-DD hh:mi[:ss]'
  if (preg_match('/^\d{4}-\d{2}-\d{2}/', $v)) return substr($v, 0, 10);
  // soporta 'DD/MM/YYYY'
  if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $v, $m)) {
    return sprintf('%04d-%02d-%02d', (int)$m[3], (int)$m[2], (int)$m[1]);
  }
  return $v;
}
function toHHMM(?string $v): string {
  $v = preg_replace('/[^0-9:]/', '', (string)$v);
  return substr($v, 0, 5); // HH:MM
}

/* ===== Data ===== */
$proximasCitas = [];
$proximosRecordatorios = [];
$errCitas = $errRecs = '';

try {
  $citasRaw = $citaModel->listar();               // puede venir OCIStatement
  $citas    = rows_from($citasRaw);
  $hoy      = date('Y-m-d');

  // normalizar y filtrar próximas
  $citasNorm = array_map(function($c){
    return [
      'PACIENTE' => $c['PACIENTE'] ?? ($c['ID_PACIENTE'] ?? ''),
      'DOCTOR'   => $c['DOCTOR']   ?? ($c['ID_DOCTOR']   ?? ''),
      'FECHA'    => toIsoDate($c['FECHA'] ?? ''),
      'HORA'     => toHHMM($c['HORA'] ?? ''),
    ];
  }, $citas);

  $proximasCitas = array_values(array_filter($citasNorm, function($c) use ($hoy) {
    return ($c['FECHA'] !== '' && $c['FECHA'] >= $hoy);
  }));

  usort($proximasCitas, function($a,$b){
    $ka = ($a['FECHA'] ?? '') . ' ' . ($a['HORA'] ?? '');
    $kb = ($b['FECHA'] ?? '') . ' ' . ($b['HORA'] ?? '');
    return strcmp($ka, $kb);
  });

  $proximasCitas = array_slice($proximasCitas, 0, 5);
} catch (Throwable $t) {
  $errCitas = $t->getMessage();
}

try {
  $recsRaw = $recordatorioModel->listar();        // puede venir OCIStatement
  $recs    = rows_from($recsRaw);
  $hoy     = date('Y-m-d');

  // normalizar y filtrar próximos
  $recsNorm = array_map(function($r){
    return [
      'ID_RECORDATORIO' => $r['ID_RECORDATORIO'] ?? null,
      'ID_CITA'         => $r['ID_CITA'] ?? null,
      'MENSAJE'         => $r['MENSAJE'] ?? '',
      'FECHA_ENVIO'     => toIsoDate($r['FECHA_ENVIO'] ?? ''),
    ];
  }, $recs);

  $recsUpcoming = array_values(array_filter($recsNorm, function($r) use ($hoy){
    return ($r['FECHA_ENVIO'] !== '' && $r['FECHA_ENVIO'] >= $hoy);
  }));

  usort($recsUpcoming, function($a,$b){
    return strcmp($a['FECHA_ENVIO'] ?? '', $b['FECHA_ENVIO'] ?? '');
  });

  $proximosRecordatorios = array_slice($recsUpcoming, 0, 5);
} catch (Throwable $t) {
  $errRecs = $t->getMessage();
}
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
              </div> <!-- col -->
            </div> <!-- row -->
          </div> <!-- container -->
        </div> <!-- hero-content -->
      </div> <!-- hero-wrapper -->
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
        <!-- Citas -->
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card text-center shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <i class="bi bi-calendar2-check-fill fs-1 text-info mb-3"></i>
              <h5 class="card-title">Citas</h5>
              <div class="mt-auto">
                <a href="../Cita/list.php" class="btn btn-outline-info mb-2 w-100">Ver agenda</a>
                <a href="../Cita/create.php" class="btn btn-info w-100">Agendar tu Cita</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagos -->
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

        <!-- Recordatorios (acceso) -->
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card text-center shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <i class="bi bi-bell-fill fs-1 text-info mb-3"></i>
              <h5 class="card-title">Recordatorios</h5>
              <div class="mt-auto">
                <a href="../Recordatorio/list.php"   class="btn btn-outline-info mb-2 w-100">Ver recordatorios</a>
                <a href="../Recordatorio/create.php" class="btn btn-info w-100">Nuevo recordatorio</a>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- row -->
    </div> <!-- container -->
  </section>

  <!-- Quick Overview: Próximas Consultas -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row g-4">
        <div class="col-12">
          <h3 class="mb-4">Próximas Consultas</h3>
          <?php if ($errCitas): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errCitas) ?></div>
          <?php endif; ?>
          <table class="table table-hover mb-0">
            <thead class="table-secondary">
              <tr><th>Paciente</th><th>Doctor</th><th>Fecha</th><th>Hora</th></tr>
            </thead>
            <tbody>
              <?php if ($proximasCitas): foreach($proximasCitas as $c): ?>
                <tr>
                  <td><?= htmlspecialchars($c['PACIENTE']) ?></td>
                  <td><?= htmlspecialchars($c['DOCTOR'])   ?></td>
                  <td><?= htmlspecialchars($c['FECHA'])    ?></td>
                  <td><?= htmlspecialchars($c['HORA'])     ?></td>
                </tr>
              <?php endforeach; else: ?>
                <tr><td colspan="4" class="text-center">Sin próximas citas</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Recordatorios al fondo -->
  <section class="py-5 border-top" id="recordatorios-bottom">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Recordatorios (próximos)</h3>
        <div class="d-flex gap-2">
          <a href="../Recordatorio/list.php" class="btn btn-outline-secondary btn-sm">Ver todos</a>
          <a href="../Recordatorio/create.php" class="btn btn-primary btn-sm">Nuevo recordatorio</a>
        </div>
      </div>

      <?php if ($errRecs): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errRecs) ?></div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-secondary">
            <tr>
              <th>Mensaje</th>
              <th class="text-center" style="width:140px;">Fecha envío</th>
              <th class="text-end" style="width:220px;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($proximosRecordatorios): foreach($proximosRecordatorios as $r): ?>
              <tr>
                <td><?= htmlspecialchars(mb_strimwidth($r['MENSAJE'], 0, 90, '…')) ?></td>
                <td class="text-center">
                  <span class="badge bg-secondary"><?= htmlspecialchars($r['FECHA_ENVIO']) ?></span>
                </td>
                <td class="text-end">
                  <a href="../Recordatorio/edit.php?id=<?=urlencode($r['ID_RECORDATORIO'])?>" class="btn btn-sm btn-outline-primary">Reprogramar</a>
                  <a href="../Recordatorio/edit.php?id=<?=urlencode($r['ID_RECORDATORIO'])?>&cancel=1"
                     class="btn btn-sm btn-outline-danger"
                     onclick="return confirm('¿Cancelar este recordatorio? Esta acción no se puede deshacer.');">
                     Cancelar
                  </a>
                </td>
              </tr>
            <?php endforeach; else: ?>
              <tr><td colspan="3" class="text-center">No hay recordatorios próximos</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</main>

<?php PrintFooter(); ?>

<a href="#" id="scroll-top" class="scroll-top"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<?php PrintScript(); ?>
</body>
</html>
