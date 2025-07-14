<?php include_once "../../Controller/PacienteController.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>

<!DOCTYPE html>

<html lang="es">

<?php PrintCss(); ?>

<body>

<?php PrintBarra(); ?>

<main class="container py-4">
    <h2>Lista de Pacientes</h2>
    <a href="create.php" class="btn btn-primary mb-3">Nuevo Paciente</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php
            $result = $pacienteModel->obtenerTodos();
            while ($row = oci_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['ID_PACIENTE']}</td>
                        <td>{$row['NOMBRE']}</td>
                        <td>{$row['EMAIL']}</td>
                        <td>{$row['TELEFONO']}</td>
                        <td>{$row['DIRECCION']}</td>
                        <td>
                            <a href='edit.php?id={$row['ID_PACIENTE']}' class='btn btn-sm btn-warning'>Editar</a>
                            <a href='delete.php?id={$row['ID_PACIENTE']}' class='btn btn-sm btn-danger'>Eliminar</a>
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
