<?php include_once "../../Controller/DoctorController.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";
?>


<!DOCTYPE html>

<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Listado de Doctores</h2>
  <a href="create.php" class="btn btn-success mb-3">Nuevo Doctor</a>
  <table class="table table-bordered">
    <thead><tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Especialidad</th><th>Acciones</th></tr></thead>
    <tbody>
      <?php
      $result = $doctorModel->obtenerTodos();
      while ($row = oci_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['ID_DOCTOR']}</td>
                <td>{$row['NOMBRE']}</td>
                <td>{$row['TELEFONO']}</td>
                <td>{$row['ESPECIALIDAD']}</td>
                <td>
                  <a href='edit.php?id={$row['ID_DOCTOR']}' class='btn btn-warning btn-sm'>Editar</a>
                  <a href='delete.php?id={$row['ID_DOCTOR']}' class='btn btn-danger btn-sm'>Eliminar</a>
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
