<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/CitaModel.php";

$model        = new CitaModel($conn);
$id           = $_GET["id"] ?? 0;
$cita         = $model->getById($id);
$pacientes    = $model->getPacientes();
$doctores     = $model->getDoctores();
$especialidades = $model->getEspecialidades();
?>

<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>

<main class="container py-4">
<div class="mb-3">
  <h2 class="mb-4">Editar Cita</h2>

  <?php if (!$cita): ?>
      <div class="alert alert-danger">Cita no encontrada.</div>
  <?php else: ?>
  <form action="../../Controller/CitaController.php" method="POST">
    <input type="hidden" name="action"   value="update">
    <input type="hidden" name="ID_CITA"  value="<?= $cita['ID_CITA'] ?>">

    <div class="mb-3">
      <label class="form-label">Fecha</label>
      <input type="date" name="FECHA" class="form-control"
             value="<?= $cita['FECHA'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Hora</label>
      <input type="time" name="HORA" class="form-control"
             value="<?= $cita['HORA'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Paciente</label>
      <select name="ID_PACIENTE" class="form-select" required>
        <?php foreach ($pacientes as $p): ?>
          <option value="<?= $p['ID_PACIENTE'] ?>"
            <?= $p['ID_PACIENTE'] == $cita['ID_PACIENTE'] ? 'selected' : '' ?>>
            <?= $p['NOMBRE'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Doctor</label>
      <select name="ID_DOCTOR" class="form-select" required>
        <?php foreach ($doctores as $d): ?>
          <option value="<?= $d['ID_DOCTOR'] ?>"
            <?= $d['ID_DOCTOR'] == $cita['ID_DOCTOR'] ? 'selected' : '' ?>>
            <?= $d['NOMBRE'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Especialidad</label>
      <select name="ID_ESPECIALIDAD" class="form-select" required>
        <?php foreach ($especialidades as $e): ?>
          <option value="<?= $e['ID_ESPECIALIDAD'] ?>"
            <?= $e['ID_ESPECIALIDAD'] == $cita['ID_ESPECIALIDAD'] ? 'selected' : '' ?>>
            <?= $e['NOMBRE'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select name="ESTADO" class="form-select" required>
        <option value="Agendada"  <?= $cita['ESTADO']=='Agendada'  ? 'selected':'' ?>>Agendada</option>
        <option value="Confirmada"<?= $cita['ESTADO']=='Confirmada'? 'selected':'' ?>>Confirmada</option>
        <option value="Cancelada" <?= $cita['ESTADO']=='Cancelada' ? 'selected':'' ?>>Cancelada</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="list.php" class="btn btn-secondary">Cancelar</a>
  </form>
  <?php endif; ?>
</div>
</main>

<?php PrintFooter(); ?>
<?php PrintScript(); ?>
</body>
</html>
