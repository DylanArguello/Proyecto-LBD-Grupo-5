<?php include_once "../../Controller/DisponibilidadController.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>

<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
    <h2>Disponibilidad de Doctores</h2>
    <a href="create.php" class="btn btn-primary mb-3">Nueva Disponibilidad</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Día</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $disponibilidadModel->obtenerTodas();
while ($row = oci_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['NOMBRE_DOCTOR']}</td>
            <td>{$row['DIA_SEMANA']}</td>
            <td>" . htmlspecialchars($row['HORA_INICIO']) . "</td>
            <td>" . htmlspecialchars($row['HORA_FIN']) . "</td>
            <td>
                <a href='edit.php?id={$row['ID_DISPONIBILIDAD']}' class='btn btn-sm btn-warning'>Editar</a>
                <a href='delete.php?id={$row['ID_DISPONIBILIDAD']}' class='btn btn-sm btn-danger'>Eliminar</a>
            </td>
          </tr>";
}
        ?>
        </tbody>
    </table>
</main>
<?php PrintFooter(); ?>
</body>
</html>
