<?php
// View/Cita/edit.php
include_once __DIR__ . "/../../Controller/CitaController.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

$vm = cita_handle_edit($_GET, $_POST);
$item      = $vm['item'];
$pacientes = $vm['pacientes'];
$doctores  = $vm['doctores'];
$dispon    = $vm['dispon'];
$fecha_val = $vm['fecha_val'];
$hora_val  = $vm['hora_val'];
$estados   = $vm['estados'];
$error     = $vm['error'];
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

    <?php
      $cd = (int)($item['ID_DOCTOR'] ?? 0);
      $slots = array_filter($dispon, fn($x) => (int)$x['ID_DOCTOR'] === $cd);
      if ($slots):
    ?>
      <div class="alert alert-info">
        <strong>Disponibilidad del doctor:</strong>
        <ul class="mb-0">
          <?php foreach ($slots as $s): ?>
            <li><?= htmlspecialchars($s['DIA_SEMANA']) ?>:
              <?= htmlspecialchars(substr($s['HORA_INICIO'],0,5)) ?>–<?= htmlspecialchars(substr($s['HORA_FIN'],0,5)) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <button class="btn btn-success">Actualizar</button>
    <a class="btn btn-secondary" href="list.php">Cancelar</a>
  </form>
  <?php endif; ?>
</main>
</body>
</html>

<?php PrintFooter(); ?>