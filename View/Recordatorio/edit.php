<?php
require_once '../../Controller/recordatorioController.php';
$controller = new RecordatorioController();

$id = $_GET['id'];
$recordatorio = $controller->show($id);
?>

<form method="POST" action="update.php">
    <input type="hidden" name="id" value="<?= $recordatorio['ID_RECORDATORIO'] ?>">
    <div class="form-group">
        <label>ID Cita</label>
        <input type="number" name="cita" class="form-control" value="<?= $recordatorio['ID_CITA'] ?>" required>
    </div>
    <div class="form-group">
        <label>Mensaje</label>
        <input type="text" name="mensaje" class="form-control" value="<?= $recordatorio['MENSAJE'] ?>" required>
    </div>
    <div class="form-group">
        <label>Fecha de Envío</label>
        <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d', strtotime($recordatorio['FECHA_ENVIO'])) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
