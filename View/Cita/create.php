<?php
include_once __DIR__ . "/../../Controller/CitaController.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

function rows_from($maybe) {
  $out = [];
  if (is_object($maybe) && get_class($maybe) === 'OCIStatement') {
    while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
  } elseif (is_resource($maybe)) {
    while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
  } elseif (is_array($maybe)) {
    $out = $maybe;
  }
  return $out;
}

$error = '';
try {
  $pacientesRaw = $pacienteModel->listar();   // pkg_paciente.sp_listar(cur) -> ID_PACIENTE, NOMBRE, ...
  $doctoresRaw  = $doctorModel->listar();     // PKG_DOCTOR.sp_listar_doctores(cur) -> ID_DOCTOR, NOMBRE, ...
  $pacientes    = rows_from($pacientesRaw);
  $doctores     = rows_from($doctoresRaw);
} catch (Throwable $t) {
  $error = $t->getMessage(); $pacientes = $doctores = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $citaModel->crear([
      'ID_PACIENTE' => $_POST['ID_PACIENTE'] ?? '',
      'ID_DOCTOR'   => $_POST['ID_DOCTOR']   ?? '',
      'FECHA'       => $_POST['FECHA']       ?? '',       // 'YYYY-MM-DD'
      'HORA'        => substr($_POST['HORA'] ?? '', 0, 5),// 'HH:MM'
      'ESTADO'      => $_POST['ESTADO']      ?? 'AGENDADA',
    ]);
    header("Location: list.php"); exit;
  } catch (Throwable $t) { $error = $t->getMessage(); }
}
$estados = ['AGENDADA','CONFIRMADA','CANCELADA'];
?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Nueva Cita</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post" autocomplete="off">
    <label class="form-label">Paciente</label>
    <select class="form-select mb-2" name="ID_PACIENTE" required>
      <option value="">-- Seleccione --</option>
      <?php foreach ($pacientes as $p): ?>
        <option value="<?= htmlspecialchars($p['ID_PACIENTE']) ?>">
          <?= htmlspecialchars($p['NOMBRE']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label class="form-label">Doctor</label>
    <select class="form-select mb-2" name="ID_DOCTOR" required>
      <option value="">-- Seleccione --</option>
      <?php foreach ($doctores as $d): ?>
        <option value="<?= htmlspecialchars($d['ID_DOCTOR']) ?>">
          <?= htmlspecialchars($d['NOMBRE']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label class="form-label">Fecha</label>
    <input class="form-control mb-2" type="date" name="FECHA" required>

    <label class="form-label">Hora</label>
    <input class="form-control mb-2" type="time" name="HORA" required>

    <label class="form-label">Estado</label>
    <select class="form-select mb-3" name="ESTADO" required>
      <?php foreach ($estados as $e): ?>
        <option value="<?= htmlspecialchars($e) ?>"><?= htmlspecialchars($e) ?></option>
      <?php endforeach; ?>
    </select>

    <button class="btn btn-success">Guardar</button>
    <a class="btn btn-secondary" href="list.php">Cancelar</a>
  </form>
</main>
</body>
</html>

<?php PrintFooter(); ?>