<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
require_once "../../models/HistorialModel.php";

$model = new HistorialModel();
$Historial = $model->getById($_GET["id"]);
?>

<?php PrintCss(); ?>
<?php PrintBarra(); ?>

<div class="container mt-5">
    <h2>Editar Historial Médico</h2>
    <form method="POST" action="../../controllers/HistorialController.php">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" value="<?= $Historial["ID_Historial"] ?>">

        <div class="mb-3">
            <label>Diagnóstico</label>
            <textarea name="diagnostico" class="form-control" required><?= $Historial["DIAGNOSTICO"] ?></textarea>
        </div>
        <div class="mb-3">
            <label>Tratamiento</label>
            <textarea name="tratamiento" class="form-control" required><?= $Historial["TRATAMIENTO"] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php PrintFooter(); ?>
