<?php
// View/Cita/edit.php
include_once __DIR__ . "/../../Controller/CitaController.php";

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: list.php"); exit; }

$error = '';

// utilidades locales para normalizar formatos
$toIsoDate = function (?string $v): string {
  $v = trim((string)$v);
  if ($v === '') return '';
  // si viene dd/mm/yyyy -> yyyy-mm-dd
  if (preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $v, $m)) {
    return sprintf('%04d-%02d-%02d', (int)$m[3], (int)$m[2], (int)$m[1]);
  }
  // ya está en yyyy-mm-dd (de inputs type="date" o del SP)
  return $v;
};
$toHHMM = function (?string $v): string {
  $v = preg_replace('/[^0-9:]/', '', (string)$v);
  return substr($v, 0, 5); // HH:MM
};

// eliminar
if (isset($_GET['delete'])) {
  try {
    $citaModel->eliminar($id);
    header("Location: list.php"); exit;
  } catch (Throwable $t) {
    $error = $t->getMessage();
  }
}

// actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $citaModel->actualizar([
      'ID_CITA'     => $id,
      'ID_PACIENTE' => $_POST['ID_PACIENTE'] ?? '',
      'ID_DOCTOR'   => $_POST['ID_DOCTOR']   ?? '',
      'FECHA'       => $toIsoDate($_POST['FECHA'] ?? ''), // -> 'YYYY-MM-DD'
      'HORA'        => $toHHMM($_POST['HORA'] ?? ''),      // -> 'HH:MM'
      'ESTADO'      => $_POST['ESTADO'] ?? 'AGENDADA',
    ]);
    header("Location: list.php"); exit;
  } catch (Throwable $t) {
    $error = $t->getMessage();
  }
}

// cargar datos
try {
  $item      = $citaModel->obtener($id);
  $pacientes = $pacienteModel->listar();
  $doctores  = $doctorModel->listar();
} catch (Throwable $t) {
  $error = $t->getMessage();
  $item = null; $pacientes = $doctores = [];
}

// valores para los inputs
$fecha_val = $toIsoDate($item['FECHA'] ?? '');
$hora_val  = $toHHMM($item['HORA'] ?? '');
$estados   = ['AGENDADA','CONFIRMADA','CANCELADA'];

include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Editar Cita</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (!$item): ?>
    <div class="alert alert-warning">No se encontró la cita solicitada.</div>
    <a class="btn btn-secondary" href="list.php">Volver</a>
  <?php else: ?>
  <form method="post" autocomplete="off">
    <label class="form-label">Paciente</label>
    <select class="form-select mb-2" name="ID_PACIENTE" required>
      <?php $cp = (int)($item['ID_PACIENTE'] ?? 0); ?>
      <?php foreach ($pacientes as $p): ?>
        <option value="<?= htmlspecialchars($p['ID_PACIENTE']) ?>"
          <?= ($cp === (int)$p['ID_PACIENTE']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($p['NOMBRE'] ?? $p['ID_PACIENTE']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label class="form-label">Doctor</label>
    <select class="form-select mb-2" name="ID_DOCTOR" required>
      <?php $cd = (int)($item['ID_DOCTOR'] ?? 0); ?>
      <?php foreach ($doctores as $d): ?>
        <option value="<?= htmlspecialchars($d['ID_DOCTOR']) ?>"
          <?= ($cd === (int)$d['ID_DOCTOR']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($d['NOMBRE'] ?? $d['ID_DOCTOR']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label class="form-label">Fecha</label>
    <input class="form-control mb-2" type="date" name="FECHA"
           value="<?= htmlspecialchars($fecha_val) ?>" required>

    <label class="form-label">Hora</label>
    <input class="form-control mb-2" type="time" name="HORA"
           value="<?= htmlspecialchars($hora_val) ?>" required>

    <label class="form-label">Estado</label>
    <select class="form-select mb-3" name="ESTADO" required>
      <?php $ce = $item['ESTADO'] ?? ''; ?>
      <?php foreach ($estados as $e): ?>
        <option value="<?= $e ?>" <?= ($ce === $e) ? 'selected' : '' ?>><?= $e ?></option>
      <?php endforeach; ?>
    </select>

    <button class="btn btn-success">Actualizar</button>
    <a class="btn btn-secondary" href="list.php">Cancelar</a>
  </form>
  <?php endif; ?>
</main>
</body>
</html>
