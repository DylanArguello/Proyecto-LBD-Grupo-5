<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/CitaModel.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/conexion_oracle.php";

$model = new CitaModel($conn);
$citas = $model->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>

<main class="container py-4">
<div class="mb-3">
  <h2 class="mb-4">Lista de Citas</h2>
  <a href="create.php" class="btn btn-success mb-3">Registrar nueva cita</a>

  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Paciente</th>
        <th>Doctor</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($citas as $cita): ?>
        <tr>
          <td><?= htmlspecialchars($cita['ID_CITA']) ?></td>
          <td><?= htmlspecialchars($cita['PACIENTE']) ?></td>
          <td><?= htmlspecialchars($cita['DOCTOR']) ?></td>
          <td><?= htmlspecialchars($cita['FECHA']) ?></td>
          <td><?= htmlspecialchars($cita['HORA']) ?></td>
          <td><?= htmlspecialchars($cita['ESTADO']) ?></td>
          <td>
            <a href="edit.php?id=<?= $cita['ID_CITA'] ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="../../Controller/CitaController.php?action=delete&id=<?= $cita['ID_CITA'] ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('¿Estás seguro de eliminar esta cita?')">
              Eliminar
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</main>

<?php PrintFooter(); ?>
<?php PrintScript(); ?>
</body>
</html>
