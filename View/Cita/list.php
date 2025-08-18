<?php
include_once __DIR__ . "/../../Controller/CitaController.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

function rows_from($maybe) {
  $out = [];
  if (is_object($maybe) && get_class($maybe) === 'OCIStatement') {
    while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
  } elseif (is_resource($maybe)) {
    while ($r = oci_fetch_assoc($maybe)) { $out[] = $r; }
  } elseif (is_array($maybe)) { $out = $maybe; }
  return $out;
}

$error = ''; $rows = [];
try {
  $items = $citaModel->listar();   // PKG_CITA.sp_listar(cur)
  $rows  = rows_from($items);
} catch (Throwable $t) {
  $error = $t->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Lista de Citas</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <a class="btn btn-primary mb-3" href="create.php">Nueva Cita</a>

  <table class="table table-bordered table-sm">
    <thead>
      <tr>
        <th>ID</th><th>Paciente</th><th>Doctor</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    <?php if ($rows): foreach ($rows as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['ID_CITA']) ?></td>
        <td><?= htmlspecialchars($r['PACIENTE'] ?? $r['ID_PACIENTE'] ?? '') ?></td>
        <td><?= htmlspecialchars($r['DOCTOR']   ?? $r['ID_DOCTOR']   ?? '') ?></td>
        <td><?= htmlspecialchars($r['FECHA'] ?? '') ?></td>
        <td><?= htmlspecialchars(substr($r['HORA'] ?? '', 0, 5)) ?></td>
        <td><?= htmlspecialchars($r['ESTADO'] ?? '') ?></td>
        <td>
          <a class="btn btn-sm btn-warning" href="edit.php?id=<?= urlencode($r['ID_CITA']) ?>">Editar</a>
          <a class="btn btn-sm btn-danger"
             href="edit.php?id=<?= urlencode($r['ID_CITA']) ?>&delete=1"
             onclick="return confirm('¿Eliminar?')">Eliminar</a>
        </td>
      </tr>
    <?php endforeach; else: ?>
      <tr><td colspan="7" class="text-center">Sin registros</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
</main>
</body>
</html>
