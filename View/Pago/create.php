<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Model/PagoModel.php";
$pagoModel = new PagoModel();
$citas = $pagoModel->getCitas();
?>

<div class="container mt-4">
  <h2 class="mb-4">Registrar Pago</h2>
  <form action="../../Controller/pagoController.php" method="POST">
    <input type="hidden" name="action" value="create">

    <div class="mb-3">
      <label class="form-label">Cita</label>
      <select name="ID_CITA" class="form-select" required>
        <option value="">Seleccione una cita</option>
        <?php foreach ($citas as $cita): ?>
          <option value="<?= $cita['ID_CITA'] ?>"><?= $cita['ID_CITA'] ?> - <?= $cita['PACIENTE'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Monto</label>
      <input type="number" step="0.01" name="MONTO" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha</label>
      <input type="date" name="FECHA" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Método de Pago</label>
      <input type="text" name="METODO_PAGO" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="list.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
