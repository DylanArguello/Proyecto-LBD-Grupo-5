<?php
include_once __DIR__ . "/../../Controller/UsuarioController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

$error = '';
$rows  = [];

try {
  $items = $usuarioModel->listar();

  // Normalizar a array si vino un cursor OCI
  if (is_object($items) && (get_class($items) === 'OCIStatement' || get_class($items) === 'OCILob')) {
    while ($r = oci_fetch_assoc($items)) { $rows[] = $r; }
  } elseif (is_array($items)) {
    $rows = $items;
  } else {
    // Último intento si OracleHelper devuelve recurso
    if (is_resource($items)) {
      while ($r = oci_fetch_assoc($items)) { $rows[] = $r; }
    }
  }
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
  <h2>Usuarios</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <a class="btn btn-primary mb-3" href="create.php">Nuevo Usuario</a>

  <table class="table table-bordered table-sm">
    <thead>
      <tr><th>ID</th><th>Nombre</th><th>Tipo</th><th>Acciones</th></tr>
    </thead>
    <tbody>
    <?php if ($rows): foreach ($rows as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['ID_USUARIO']) ?></td>
        <td><?= htmlspecialchars($r['NOMBRE_USUARIO'] ?? '') ?></td>
        <td><?= htmlspecialchars($r['TIPO_USUARIO'] ?? '') ?></td>
        <td>
          <a class="btn btn-sm btn-warning"
             href="edit.php?id=<?= urlencode($r['ID_USUARIO']) ?>">Editar</a>
          <a class="btn btn-sm btn-danger"
             href="edit.php?id=<?= urlencode($r['ID_USUARIO']) ?>&delete=1"
             onclick="return confirm('¿Eliminar?')">Eliminar</a>
        </td>
      </tr>
    <?php endforeach; else: ?>
      <tr><td colspan="4" class="text-center">Sin registros</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
</main>
</body>
</html>

<?php PrintFooter(); ?>