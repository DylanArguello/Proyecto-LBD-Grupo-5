<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
require_once "../../Model/HistorialModel.php";

$model = new HistorialModel();
$pacientes = $model->getPacientes();
$citas = $model->getCitas();
?>

<?php PrintCss(); ?>
<?php PrintBarra(); ?>

<div class="container mt-5">
    <h2>Nuevo Historial Médico</h2>
    <form method="POST" action="../../controllers/HistorialController.php">
        <input type="hidden" name="create" value="1">
        <div class="mb-3">
            <label>ID Historial</label>
            <input type="number" name="id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Paciente</label>
            <select name="paciente" class="form-control" required>
                <?php foreach ($pacientes as $p): ?>
                    <option value="<?= $p["ID_PACIENTE"] ?>"><?= $p["NOMBRE"] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Cita</label>
            <select name="cita" class="form-control" required>
                <?php foreach ($citas as $c): ?>
                    <option value="<?= $c["ID_CITA"] ?>"><?= $c["ID_CITA"] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Diagnóstico</label>
            <textarea name="diagnostico" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Tratamiento</label>
            <textarea name="tratamiento" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php PrintFooter(); ?>
