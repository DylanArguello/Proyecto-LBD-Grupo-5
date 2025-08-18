<?php
include_once __DIR__ . "/../../Controller/PacienteController.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
require_once __DIR__ . "/../../Utils/Validator.php";
require_once __DIR__ . "/../../Utils/AppErrors.php";

$error = '';                  // error global (alerta roja)
$ferr  = [];                  // errores por campo (para is-invalid)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // Validaciones previas (UX)
    if (!Validator::required($_POST['NOMBRE'] ?? '')) $ferr['NOMBRE'] = 'Obligatorio.';
    if (!Validator::email($_POST['EMAIL'] ?? ''))     $ferr['EMAIL']  = 'Ingresa un correo válido.';
    if ($ferr) throw new Exception('Por favor corrige los campos marcados.');

    // Crear en BD — si hay ORA-00001, OracleHelper lanzará AppException amigable
    $pacienteModel->crear([
      'NOMBRE'    => $_POST['NOMBRE']    ?? '',
      'EMAIL'     => $_POST['EMAIL']     ?? '',
      'TELEFONO'  => $_POST['TELEFONO']  ?? '',
      'DIRECCION' => $_POST['DIRECCION'] ?? '',
    ]);
    header("Location: list.php"); exit;

  } catch (AppException $ex) {
    if ($ex->field) $ferr[$ex->field] = $ex->getMessage();
    else $error = $ex->getMessage();
  } catch (Throwable $t) {
    $error = $t->getMessage();
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Nuevo Paciente</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post" autocomplete="off" novalidate>
    <label class="form-label">Nombre</label>
    <input class="form-control mb-2 <?= isset($ferr['NOMBRE']) ? 'is-invalid' : '' ?>"
           name="NOMBRE" required
           value="<?= htmlspecialchars($_POST['NOMBRE'] ?? '') ?>">
    <?php if (isset($ferr['NOMBRE'])): ?>
      <div class="invalid-feedback"><?= htmlspecialchars($ferr['NOMBRE']) ?></div>
    <?php endif; ?>

    <label class="form-label">Email</label>
    <input class="form-control mb-2 <?= isset($ferr['EMAIL']) ? 'is-invalid' : '' ?>"
           name="EMAIL" type="email" required
           value="<?= htmlspecialchars($_POST['EMAIL'] ?? '') ?>">
    <?php if (isset($ferr['EMAIL'])): ?>
      <div class="invalid-feedback"><?= htmlspecialchars($ferr['EMAIL']) ?></div>
    <?php endif; ?>

    <label class="form-label">Teléfono</label>
    <input class="form-control mb-2 <?= isset($ferr['TELEFONO']) ? 'is-invalid' : '' ?>"
           name="TELEFONO"
           value="<?= htmlspecialchars($_POST['TELEFONO'] ?? '') ?>">
    <?php if (isset($ferr['TELEFONO'])): ?>
      <div class="invalid-feedback"><?= htmlspecialchars($ferr['TELEFONO']) ?></div>
    <?php endif; ?>

    <label class="form-label">Dirección</label>
    <input class="form-control mb-3 <?= isset($ferr['DIRECCION']) ? 'is-invalid' : '' ?>"
           name="DIRECCION"
           value="<?= htmlspecialchars($_POST['DIRECCION'] ?? '') ?>">
    <?php if (isset($ferr['DIRECCION'])): ?>
      <div class="invalid-feedback"><?= htmlspecialchars($ferr['DIRECCION']) ?></div>
    <?php endif; ?>

    <button class="btn btn-success">Guardar</button>
    <a class="btn btn-secondary" href="list.php">Cancelar</a>
  </form>
</main>
</body>
</html>

<?php PrintFooter(); ?>