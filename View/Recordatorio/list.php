<?php
require_once '../../Controller/recordatorioController.php';
$controller = new RecordatorioController();
$recordatorios = $controller->index();
?>

<h2>Lista de Recordatorios</h2>
<a href="create.php" class="btn btn-primary mb-3">Nuevo Recordatorio</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Mensaje</th>
            <th>Fecha Envío</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recordatorios as $rec): ?>
        <tr>
            <td><?= $rec['ID_RECORDATORIO'] ?></td>
            <td><?= $rec['PACIENTE'] ?></td>
            <td><?= $rec['MENSAJE'] ?></td>
            <td><?= $rec['FECHA_ENVIO'] ?></td>
            <td>
                <a href="edit.php?id=<?= $rec['ID_RECORDATORIO'] ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="delete.php?id=<?= $rec['ID_RECORDATORIO'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('¿Estás seguro de eliminar este recordatorio?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
