<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/CitaModel.php";

$citaModel = new CitaModel($conn);
$nextId = $citaModel->getNextId();
$pacientes = $citaModel->getPacientes();
$doctores = $citaModel->getDoctores();
$especialidades = $citaModel->getEspecialidades();
?>

<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>

<main class="container py-4">
<div class="mb-3">
  <h2 class="mb-4">Registrar Cita</h2>
  <form action="../../Controller/CitaController.php" method="POST">
    <input type="hidden" name="action" value="create">
    <input type="hidden" name="ID_CITA" value="<?= $nextId ?>">

    <div class="mb-3">
      <label class="form-label">Fecha</label>
      <input type="date" name="FECHA" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Hora</label>
      <input type="time" name="HORA" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Paciente</label>
      <select name="ID_PACIENTE" class="form-select" required>
        <option value="">Seleccione un paciente</option>
        <?php foreach ($pacientes as $p): ?>
          <option value="<?= $p['ID_PACIENTE'] ?>"><?= $p['NOMBRE'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Doctor</label>
      <select name="ID_DOCTOR" class="form-select" required>
        <option value="">Seleccione un doctor</option>
        <?php foreach ($doctores as $d): ?>
          <option value="<?= $d['ID_DOCTOR'] ?>"><?= $d['NOMBRE'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Especialidad</label>
      <select name="ID_ESPECIALIDAD" class="form-select" required>
        <option value="">Seleccione una especialidad</option>
        <?php foreach ($especialidades as $e): ?>
          <option value="<?= $e['ID_ESPECIALIDAD'] ?>"><?= $e['NOMBRE'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <input type="hidden" name="ESTADO" value="Agendada">

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="list.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</main>

<?php PrintFooter(); ?>
<?php PrintScript(); ?>
</body>
</html>
