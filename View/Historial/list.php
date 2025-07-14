<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
require_once "../../models/HistorialModel.php";

$model = new HistorialModel();
$Historiales = $model->getAll();
?>

<?php PrintCss(); ?>
<?php PrintBarra(); ?>

<div class="container mt-5">
    <h2 class="mb-4">Historial Médico</h2>
    <a href="create.php" class="btn btn-primary mb-3">Nuevo Historial</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha</th>
                <th>Diagnóstico</th>
                <th>Tratamiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Historiales as $row): ?>
            <tr>
                <td><?= $row["PACIENTE"] ?></td>
                <td><?= $row["MEDICO"] ?></td>
                <td><?= $row["FECHA"] ?></td>
                <td><?= $row["DIAGNOSTICO"] ?></td>
                <td><?= $row["TRATAMIENTO"] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row["ID_Historial"] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <form method="POST" action="../../controllers/HistorialController.php" class="d-inline">
                        <input type="hidden" name="id" value="<?= $row["ID_Historial"] ?>">
                        <button type="submit" name="delete" class="btn btn-sm btn-danger"
                        onclick="return confirm('¿Desea eliminar el Historial?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php PrintFooter(); ?>
