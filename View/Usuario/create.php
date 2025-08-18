<?php
include_once __DIR__ . "/../../Controller/UsuarioController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
require_once __DIR__ . "/../../Utils/Validator.php";
require_once __DIR__ . "/../../Utils/AppErrors.php";

$error = '';
$ferr  = [];
$tipos = ['ADMIN','RECEPCIONISTA','DOCTOR'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    if (!Validator::required($_POST['NOMBRE_USUARIO'] ?? '')) $ferr['NOMBRE_USUARIO'] = 'Obligatorio.';
    if (!Validator::required($_POST['CONTRASENA'] ?? ''))     $ferr['CONTRASENA']     = 'Obligatorio.';
    if (!Validator::enum($_POST['TIPO_USUARIO'] ?? '', $tipos)) $ferr['TIPO_USUARIO'] = 'Tipo inválido.';
    if ($ferr) throw new Exception('Por favor corrige los campos marcados.');

    $usuarioModel->crear([
      'NOMBRE_USUARIO' => $_POST['NOMBRE_USUARIO'] ?? '',
      'CONTRASENA'     => $_POST['CONTRASENA']     ?? '',
      'TIPO_USUARIO'   => $_POST['TIPO_USUARIO']   ?? '',
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
  <h2>Nuevo Usuario</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post" autocomplete="off" novalidate>
    <label class="form-label">Nombre de usuario</label>
    <input class="form-control mb-2 <?= isset($ferr['NOMBRE_USUARIO']) ? 'is-invalid' : '' ?>"
           name="NOMBRE_USUARIO" required
           value="<?= htmlspecialchars($_POST['NOMBRE_USUARIO'] ?? '') ?>">
    <?php if (isset($ferr['NOMBRE_USUARIO'])): ?>
      <div class="invalid-feedback"><?= htmlspecialchars($ferr['NOMBRE_USUARIO']) ?></div>
    <?php endif; ?>

    <label class="form-label">Contraseña</label>
    <input class="form-control mb-2 <?= isset($ferr['CONTRASENA']) ? 'is-invalid' : '' ?>"
           type="password" name="CONTRASENA" required>
    <?php if (isset($ferr['CONTRASENA'])): ?>
      <div class="invalid-feedback"><?= htmlspecialchars($ferr['CONTRASENA']) ?></div>
    <?php endif; ?>

    <label class="form-label">Tipo</label>
    <select class="form-select mb-3 <?= isset($ferr['TIPO_USUARIO']) ? 'is-invalid' : '' ?>"
            name="TIPO_USUARIO" required>
      <?php foreach ($tipos as $t): ?>
        <option value="<?= htmlspecialchars($t) ?>"
          <?= (($_POST['TIPO_USUARIO'] ?? '') === $t) ? 'selected' : '' ?>>
          <?= htmlspecialchars($t) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <?php if (isset($ferr['TIPO_USUARIO'])): ?>
      <div class="invalid-feedback"><?= htmlspecialchars($ferr['TIPO_USUARIO']) ?></div>
    <?php endif; ?>

    <button class="btn btn-success">Guardar</button>
    <a class="btn btn-secondary" href="list.php">Cancelar</a>
  </form>
</main>
</body>
</html>
