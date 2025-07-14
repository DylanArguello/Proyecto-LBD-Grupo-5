<?php
include_once "../../Controller/DoctorController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorModel->insertar($_POST["id"], $_POST["nombre"], $_POST["telefono"], $_POST["id_especialidad"]);
    header("Location: list.php");
}
$especialidades = $doctorModel->obtenerEspecialidades();
?>

<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Nuevo Doctor</h2>
  <form method="post">
    <div class="mb-3">
      <label>ID Doctor</label>
      <input type="number" name="id" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Teléfono</label>
      <input type="text" name="telefono" class="form-control">
    </div>
    <div class="mb-3">
      <label>Especialidad</label>
      <select name="id_especialidad" class="form-control" required>
        <option value="">Seleccione...</option>
        <?php while ($esp = oci_fetch_assoc($especialidades)) {
          echo "<option value='{$esp['ID_ESPECIALIDAD']}'>{$esp['NOMBRE']}</option>";
        } ?>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="list.php" class="btn btn-secondary">Cancelar</a>
  </form>
</main>
<?php PrintFooter(); ?>
</body>
</html>