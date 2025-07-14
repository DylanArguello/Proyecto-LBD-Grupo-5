<?php
include_once "../../Controller/DoctorController.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutInterno.php";

$id = $_GET["id"];
$datos = $doctorModel->obtenerPorId($id);
$especialidades = $doctorModel->obtenerEspecialidades();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorModel->actualizar($_POST["id"], $_POST["nombre"], $_POST["telefono"], $_POST["id_especialidad"]);
    header("Location: list.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<?php PrintCss(); ?>
<body>
<?php PrintBarra(); ?>
<main class="container py-4">
  <h2>Editar Doctor</h2>
  <form method="post">
    <input type="hidden" name="id" value="<?= $datos['ID_DOCTOR'] ?>">
    <div class="mb-3">
      <label>Nombre</label>
      <input type="text" name="nombre" class="form-control" value="<?= $datos['NOMBRE'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Teléfono</label>
      <input type="text" name="telefono" class="form-control" value="<?= $datos['TELEFONO'] ?>">
    </div>
    <div class="mb-3">
      <label>Especialidad</label>
      <select name="id_especialidad" class="form-control" required>
        <?php while ($esp = oci_fetch_assoc($especialidades)) {
          $selected = ($esp['ID_ESPECIALIDAD'] == $datos['ID_ESPECIALIDAD']) ? "selected" : "";
          echo "<option value='{$esp['ID_ESPECIALIDAD']}' $selected>{$esp['NOMBRE']}</option>";
        } ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="list.php" class="btn btn-secondary">Cancelar</a>
  </form>
</main>
<?php PrintFooter(); ?>
</body>
</html>
