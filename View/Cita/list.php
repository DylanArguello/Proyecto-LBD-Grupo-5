<?php
require_once "../../Controller/CitaController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
$resultado = $cita->getAll();
?>

<h2>Listado de Citas</h2>
<a href="create.php" class="btn btn-primary mb-3">Nueva Cita</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Paciente</th><th>Doctor</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = oci_fetch_assoc($resultado)) : ?>
        <tr>
            <td><?= $row['ID_CITA'] ?></td>
            <td><?= $row['PACIENTE'] ?></td>
            <td><?= $row['DOCTOR'] ?></td>
            <td><?= $row['FECHA'] ?></td>
            <td><?= $row['HORA'] ?></td>
            <td><?= $row['ESTADO'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['ID_CITA'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="delete.php?id=<?= $row['ID_CITA'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
